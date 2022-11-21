<?php
namespace App\Service;

use \App\Models\Portal;

class Wawe
{
    public static function getDetail($access_token)
    {
        global $CPortal;
        $headers = [
            'Authorization: Bearer '.$access_token,
            'Content-Type: application/json',
        ];
        $graph = '{ "query": "query { user { id firstName lastName defaultEmail createdAt }, businesses { edges { node { id name } } } }, ", "variables": {} }';
        $result = static::call([], WAWE_URL_REQUEST, 'POST', $headers, $graph);
        if (strpos($result, 'UNAUTHENTICATED') !== false) {
            if(!empty($CPortal['wawe_access_token'])) {
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
        if(!empty($portal)) {
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
            if(!empty($result['access_token'])){
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

        if(!empty($portal)) {
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
        if(!empty($rawData)) {
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

            if(!empty($headers)) {
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
                    'url'    => $url,
                    'info'   => $info,
                    'params' => $arParams,
                    'result' => $out
                ]
            );

            return $out;

        }catch(Exception $e) {
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
        $portal = empty($_REQUEST['DOMAIN'])?'default':$_REQUEST['DOMAIN'];

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
}