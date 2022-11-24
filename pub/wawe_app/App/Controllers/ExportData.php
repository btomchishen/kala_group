<?php

namespace App\Controllers;

use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Portal;
use App\Models\Product;
use App\Service\Bitrix;
use App\Service\ClearLogs;
use App\Service\Wawe;
use \Core\View;
use \App\Service\CRest;
use Exception;

class ExportData extends \Core\Controller
{
    public function indexAction()
    {
        $portal = Portal::getByDomain($_REQUEST['DOMAIN']);

//        $result['products'] = self::exportProducts($portal, $_REQUEST);
//        $result['contacts'] = self::exportCustomers($portal, $_REQUEST);
//        $result['invoices'] = self::exportInvoices($portal, $_REQUEST);
//        p(Wawe::getInvoices($portal));
//        p(Product::getById(1));
//        p(Bitrix::getProductsByInvoice($invoiceId));
        View::render('Export/index.php',
            array(
//                'products' => $result['products'],
//                'contacts' => $result['contacts'],
//                'invoices' => $result['invoices']
            )
        );
    }

    public function exportProducts($portal, $request)
    {
        $incomeAccounts = Wawe::getIncomeAccounts($portal);
        $incomeAccountId = $incomeAccounts['data']['business']['accounts']['edges'][1]['node']['id']; // Sales Income Account ID

        // Filter by date range
        $filter = Bitrix::prepareDateRangeFilter($request['dateRange']);

        // Get total count of needed products
        $productsCount = Bitrix::getProducts(array('filter' => $filter))['total'];

        if ($productsCount > 0) {
            $pagesCount = ceil($productsCount / 50);

            for ($i = 1; $i <= $pagesCount; $i++) {
                $products = Bitrix::getProducts([
                    'filter' => $filter,
                    'start' => $i * 50
                ]);

                foreach ($products['result'] as $product) {
                    $productWave = [
                        'name' => $product['NAME'],
                        'description' => $product['DESCRIPTION'],
                        'price' => $product['PRICE'],
                        'incomeAccountId' => $incomeAccountId
                    ];

                    try {
                        $isProductExist = !empty(Product::getById($product['ID'])) ? true : false;
                        if (!$isProductExist) {
                            $productResult = Wawe::createProduct($portal, $productWave);

                            if ($productResult['data']['productCreate']['product']['id']) {
                                $params = [
                                    'product_bitrix_id' => $product['ID'],
                                    'product_wave_id' => $productResult['data']['productCreate']['product']['id']
                                ];
                                Product::add($params);
                            }
                        }
                    } catch (Exception $e) {
                        Wawe::setLog(
                            [
                                'message' => $e->getMessage(),
                                'code' => $e->getCode(),
                                'trace' => $e->getTrace()
                            ]
                        );
                    }
                }
            }
        }
    }

    public function exportCustomers($portal, $request)
    {
        // Filter by date range
        $filter = Bitrix::prepareDateRangeFilter($request['dateRange']);
        // Selected fields
        $select = ['ID', 'NAME', 'LAST_NAME', 'EMAIL', 'PHONE', 'COMMENTS'];

        // Get total count of needed products
        $contactsCount = Bitrix::getContacts(array('filter' => $filter))['total'];

        if ($contactsCount > 0) {
            $pagesCount = ceil($contactsCount / 50);

            for ($i = 1; $i <= $pagesCount; $i++) {
                $contacts = Bitrix::getContacts([
                    'filter' => $filter,
                    'select' => $select,
                    'start' => $i * 50
                ]);

                foreach ($contacts['result'] as $contact) {
                    $contactEmail = array_shift($contact['EMAIL'])['VALUE'];
                    $contactPhone = array_shift($contact['PHONE'])['VALUE'];

                    $customerWave = [
                        'name' => $contact['NAME'] . ' ' . $contact['LAST_NAME'],
                        'firstName' => $contact['NAME'],
                        'lastName' => $contact['LAST_NAME'],
                        'email' => $contactEmail,
                        'phone' => $contactPhone,
                        'internalNotes' => $contact['COMMENTS'],
                        'address' => [
                            'city' => 'North Pole',
                            'postalCode' => 'H0H 0H0',
                            'provinceCode' => 'CA-NU',
                            'countryCode' => 'CA'
                        ],
                        'currency' => 'CAD'
                    ];

                    try {
                        $isCustomerExist = !empty(Contact::getById($contact['ID'])) ? true : false;
                        if (!$isCustomerExist) {
                            $customer = Wawe::createCustomer($portal, $customerWave);

                            if ($customer['data']['customerCreate']['customer']['id']) {
                                $params = [
                                    'contact_bitrix_id' => $contact['ID'],
                                    'customer_wave_id' => $customer['data']['customerCreate']['customer']['id']
                                ];
                                Contact::add($params);
                            }
                        }
                    } catch (Exception $e) {
                        Wawe::setLog(
                            [
                                'message' => $e->getMessage(),
                                'code' => $e->getCode(),
                                'trace' => $e->getTrace()
                            ]
                        );
                    }
                }
            }
        }
    }

    public function exportInvoices($portal, $request)
    {
        // Filter by date range
        $filter = Bitrix::prepareInvoicesDateFilter($request['dateRange']);

        // Get total count of needed invoices
        $invoicesCount = Bitrix::getInvoices(array('filter' => $filter))['total'];

        if ($invoicesCount > 0) {
            $pagesCount = ceil($invoicesCount / 50);

            for ($i = 1; $i <= $pagesCount; $i++) {
                $invoices = Bitrix::getInvoices([
                    'filter' => $filter,
                    'start' => $i * 50
                ]);

                foreach ($invoices['result']['items'] as $invoice) {
                    $isInvoiceExist = !empty(Invoice::getById($invoice['id'])) ? true : false;

                    if (!$isInvoiceExist) {
                        $contactId = $invoice['contactId'];
                        $productIds = Bitrix::getProductsByInvoice($invoice['id']);

                        $waveContact = Contact::getById($contactId);
                        if (!empty($waveContact))
                            $waveContact = $waveContact['customer_wave_id'];

                        $waveProducts = [];
                        foreach ($productIds as $productId) {
                            $waveProduct = Product::getById($productId);

                            if (!empty($waveProduct))
                                $waveProducts[]['productId'] = $waveProduct['product_wave_id'];
                        }

                        $invoiceWave = [
                            'customerId' => $waveContact,
                            'items' => $waveProducts
                        ];

                        try {
                            $invoiceResult = Wawe::createInvoice($portal, $invoiceWave);

                            if ($invoiceResult['data']['invoiceCreate']['invoice']['id']) {
                                $params = [
                                    'invoice_bitrix_id' => $invoice['id'],
                                    'invoice_wave_id' => $invoiceResult['data']['invoiceCreate']['invoice']['id']
                                ];

                                Invoice::add($params);
                            }
                        } catch (Exception $e) {
                            Wawe::setLog(
                                [
                                    'message' => $e->getMessage(),
                                    'code' => $e->getCode(),
                                    'trace' => $e->getTrace()
                                ]
                            );
                        }
                    }
                }
            }
        }
    }

    public function before()
    {
        parent::before();
        ClearLogs::clear();
        $validAccess = false;
        if (!empty($_REQUEST['DOMAIN']) && !empty($_REQUEST['AUTH_ID'])) {
            $validAccess = CRest::checkAccessParams($_REQUEST['DOMAIN'], $_REQUEST['AUTH_ID']);
        }
        if ($validAccess === false) {
            http_response_code(404);
            die('404');
        }
    }
}
