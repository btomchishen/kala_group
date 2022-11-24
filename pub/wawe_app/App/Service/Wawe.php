<?php

namespace App\Service;

use \App\Models\Portal;

class Wawe
{
    public static function getDetail($access_token)
    {
        global $CPortal;
        $headers = [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json',
        ];
        $graph = '{ "query": "query { user { id firstName lastName defaultEmail createdAt }, businesses { edges { node { id name } } } }, ", "variables": {} }';
        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);
        if (strpos($result, 'UNAUTHENTICATED') !== false) {
            if (!empty($CPortal['wawe_access_token'])) {
                static::refreshToken($CPortal['wawe_access_token']);
                $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);
            }
        }
        $result = json_decode($result, true);
        return $result;
    }

    public static function refreshToken($access_token)
    {
        $token = '';
        $portal = Portal::getByField('wawe_access_token', $access_token);
        if (!empty($portal)) {
            $_REQUEST['DOMAIN'] = $portal['portal_domain'];
            $result = static::call(
                [
                    'client_id' => $portal['wawe_client_id'],
                    'client_secret' => $portal['wawe_client_secret'],
                    'refresh_token' => $portal['wawe_refresh_token'],
                    'grant_type' => 'refresh_token',
                    'redirect_uri' => WAWE_REDIRECT_URL
                ],
                WAWE_URL_TOKEN
            );
            $result = json_decode($result, true);
            if (!empty($result['access_token'])) {
                Portal::update([
                    'wawe_access_token' => $result['access_token'],
                    'wawe_token_type' => $result['token_type'],
                    'wawe_scope' => $result['scope'],
                    'wawe_refresh_token' => $result['refresh_token'],
                    'wawe_userId' => $result['userId'],
                    'wawe_businessId' => $result['businessId'],
                    'portal_domain' => $portal['portal_domain']
                ]);
                $token = $result['access_token'];
            }

        }

        return $token;
    }

    public static function getToken($state, $code)
    {
        $result = false;
        $portal = Portal::getByField('wawe_state', $state);

        if (!empty($portal)) {
            $_REQUEST['DOMAIN'] = $portal['portal_domain'];
            $result = static::call(
                [
                    'client_id' => $portal['wawe_client_id'],
                    'client_secret' => $portal['wawe_client_secret'],
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => WAWE_REDIRECT_URL,
                ],
                WAWE_URL_TOKEN
            );
            $result = json_decode($result, true);
            $result['portal_domain'] = $portal['portal_domain'];
        }

        return $result;
    }

    public static function call($arParams, $url, $method = 'POST', $headers = [], $rawData = '')
    {
        if (!empty($rawData)) {
            $sPostFields = $rawData;
        } else {
            $sPostFields = http_build_query($arParams);
        }

        try {

            $obCurl = curl_init();
            curl_setopt($obCurl, CURLOPT_URL, $url);
            curl_setopt($obCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($obCurl, CURLOPT_POSTREDIR, 10);
            curl_setopt($obCurl, CURLOPT_USERAGENT, 'Bitrix24 PHP ');

            if (!empty($headers)) {
                curl_setopt($obCurl, CURLOPT_HTTPHEADER, $headers);
            }

            if ($method === 'POST') {
                curl_setopt($obCurl, CURLOPT_POST, true);
            }
            curl_setopt($obCurl, CURLOPT_POSTFIELDS, $sPostFields);

            $out = curl_exec($obCurl);
            $info = curl_getinfo($obCurl);

            if (curl_errno($obCurl)) {
                $info['curl_error'] = curl_error($obCurl);
            }
            curl_close($obCurl);

            static::setLog(
                [
                    'url' => $url,
                    'info' => $info,
                    'params' => $arParams,
                    'result' => $out
                ]
            );

            return $out;

        } catch (Exception $e) {
            static::setLog(
                [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTrace(),
                    'params' => $arParams
                ],
                'exceptionCurl'
            );

            return [
                'error' => 'exception',
                'error_exception_code' => $e->getCode(),
                'error_information' => $e->getMessage(),
            ];
        }
    }

    public static function setLog($arData)
    {
        $portal = empty($_REQUEST['DOMAIN']) ? 'default' : $_REQUEST['DOMAIN'];

        $path = realpath(__DIR__ . '/../..');
        $path .= '/logs/' . $portal . '/wawe/';

        if (!file_exists($path)) {
            @mkdir($path, 0775, true);
        }

        $path .= date('Y_m_d') . '.txt';
        $data = date("H:i:s") . "\n" . print_r($arData, true) . "\n";
        $data .= '****************************************************************' . "\n";
        $return = file_put_contents($path, $data, FILE_APPEND);
        return $return;
    }

    public static function getIncomeAccounts($portal)
    {
        $headers = [
            'Authorization: Bearer ' . $portal['wawe_access_token'],
            'Content-Type: application/json',
        ];

        $graph = '{
            "query": "query ($businessId: ID!, $page: Int!, $pageSize: Int!) { business(id: $businessId) { id accounts(page: $page, pageSize: $pageSize, types: [INCOME]) { pageInfo { currentPage totalPages totalCount } edges { node { id name description displayId type { name value } subtype { name value } normalBalanceType isArchived } } } }}",
            "variables": {
                "businessId": "' . $portal['wawe_businessId'] . '",
                "page": 1,
                "pageSize": 50
            }
        }';

        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);

        return json_decode($result, true);
    }

    public static function createProduct($portal, $product)
    {
        $headers = [
            'Authorization: Bearer ' . $portal['wawe_access_token'],
            'Content-Type: application/json',
        ];

        $graph = '{
            "query": "mutation ($input: ProductCreateInput!) { productCreate(input: $input) { didSucceed inputErrors { code message path } product { id name description unitPrice incomeAccount { id name } expenseAccount { id name } isSold isBought isArchived createdAt modifiedAt } }}",
            "variables":{
                "input": {
                    "businessId": "' . $portal['wawe_businessId'] . '",
                    "name": "' . $product['name'] . '",
                    "description": "' . $product['description'] . '",
                    "unitPrice": "' . $product['price'] . '",
                    "incomeAccountId": "' . $product['incomeAccountId'] . '"
                }
            }
        }';

        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);

        return json_decode($result, true);
    }

    public static function createCustomer($portal, $customer)
    {
        $headers = [
            'Authorization: Bearer ' . $portal['wawe_access_token'],
            'Content-Type: application/json',
        ];

        $graph = '{
            "query": "mutation ($input: CustomerCreateInput!) { customerCreate(input: $input) { didSucceed inputErrors { code message path } customer { id name firstName lastName email address { addressLine1 addressLine2 city province { code name } country { code name } postalCode } currency { code } } }}",
            "variables":{
                "input": {
                    "businessId": "' . $portal['wawe_businessId'] . '",
                    "name": "' . $customer['name'] .'",
                    "firstName": "' . $customer['firstName'] .'",
                    "lastName": "' . $customer['lastName'] .'",
                    "email": "' . $customer['email'] .'",
                    "phone": "' . $customer['phone'] .'",
                    "internalNotes": "' . $customer['internalNotes'] .'",
                    "address": {
                        "city": "' . $customer['address']['city'] .'",
                        "postalCode": "' . $customer['address']['postalCode'] .'",
                        "provinceCode": "' . $customer['address']['provinceCode'] .'",
                        "countryCode": "' . $customer['address']['countryCode'] .'"
                    },
                    "currency": "' . $customer['currency'] .'"
                }
            }
        }';

        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);

        return json_decode($result, true);
    }

    public static function createInvoice($portal, $invoice)
    {
        $headers = [
            'Authorization: Bearer ' . $portal['wawe_access_token'],
            'Content-Type: application/json',
        ];

        $graph = '{
                "query": "mutation InvoiceCreateInput($input: InvoiceCreateInput!) { invoiceCreate(input: $input) { didSucceed inputErrors { path message code } invoice { id createdAt modifiedAt pdfUrl viewUrl status title invoiceNumber invoiceDate }} }",
                "variables": {
                    "input": {
                        "businessId": "' . $portal['wawe_businessId'] . '",
                        "customerId": "' . $invoice['customerId'] . '",
                        "status": "SAVED",
                        "items": [
                            {
                                "productId": "' . $invoice['items'][0]['productId'] . '"
                            }
                        ]
                    }
                }
        }';

        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);

        return json_decode($result, true);
    }

    public static function getInvoices($portal)
    {
        $headers = [
            'Authorization: Bearer ' . $portal['wawe_access_token'],
            'Content-Type: application/json',
        ];

        $graph = '{
            "query": "query ($businessId: ID!, $page: Int!, $pageSize: Int!) { business(id: $businessId) { id isClassicInvoicing invoices(page: $page, pageSize: $pageSize) { pageInfo { currentPage totalPages totalCount } edges { node { id createdAt modifiedAt pdfUrl viewUrl status title subhead invoiceNumber invoiceDate poNumber customer { id name } currency { code } dueDate amountDue { value currency { symbol } } amountPaid { value currency { symbol } } taxTotal { value currency { symbol } } total { value currency { symbol } } exchangeRate footer memo disableCreditCardPayments disableBankPayments itemTitle unitTitle priceTitle amountTitle hideName hideDescription hideUnit hidePrice hideAmount items { product { id name } description quantity price subtotal { value currency { symbol } } total { value currency { symbol } } account { id name subtype { name value } } taxes { amount { value } salesTax { id name } } } lastSentAt lastSentVia lastViewedAt } } } }}",
            "variables": {
                "businessId": "' . $portal['wawe_businessId'] . '",
                "page": 1,
                "pageSize": 50
            }
        }';

        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);

        return json_decode($result, true);
    }
}