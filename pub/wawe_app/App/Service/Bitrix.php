<?php

namespace App\Service;

class Bitrix
{
    public static function getContacts($arParams = array())
    {
        $order = empty($arParams['order']) ? ['DATE_CREATE' => 'ASC'] : $arParams['order'];
        $filter = empty($arParams['filter']) ? [] : $arParams['filter'];
        $select = empty($arParams['select']) ? ['*', 'UF_*'] : $arParams['select'];
        $start = empty($arParams['start']) ? 50 : $arParams['start'];

        $contacts = CRest::call(
            'crm.contact.list',
            [
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
                'start' => $start
            ]
        );

        return $contacts;
    }

    public static function getCompanies($arParams = array())
    {
        $order = empty($arParams['order']) ? ['DATE_CREATE' => 'ASC'] : $arParams['order'];
        $filter = empty($arParams['filter']) ? [] : $arParams['filter'];
        $select = empty($arParams['select']) ? ['*', 'UF_*'] : $arParams['select'];
        $start = empty($arParams['start']) ? 50 : $arParams['start'];

        $companies = CRest::call(
            'crm.company.list',
            [
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
                'start' => $start
            ]
        );

        return $companies;
    }

    public static function getProducts($arParams = array())
    {
        $order = empty($arParams['order']) ? ['DATE_CREATE' => 'ASC'] : $arParams['order'];
        $filter = empty($arParams['filter']) ? [] : $arParams['filter'];
        $select = empty($arParams['select']) ? ['*'] : $arParams['select'];
        $start = empty($arParams['start']) ? 50 : $arParams['start'];

        $products = CRest::call(
            'crm.product.list',
            [
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
                'start' => $start
            ]
        );

        return $products;
    }

    public static function getProductsByInvoice($invoiceId, $arParams = array())
    {
        $order = empty($arParams['order']) ? [] : $arParams['order'];
        $filter = empty($arParams['filter']) ? [] : $arParams['filter'];
        $select = empty($arParams['select']) ? [] : $arParams['select'];

        $filter = array_merge($filter, [
            '=ownerType' => 'SI',
            "=ownerId"=> $invoiceId
        ]);

        $invoices = CRest::call(
            'crm.item.productrow.list',
            [
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
            ]
        );

        $products = [];
        if ($invoices['total'] > 0) {
            foreach ($invoices['result']['productRows'] as $product) {
                $products[] = $product['id'];
            }
        }

        return $products;
    }

    public static function getInvoices($arParams = array())
    {
        $order = empty($arParams['order']) ? ['createdTime' => 'ASC'] : $arParams['order'];
        $filter = empty($arParams['filter']) ? [] : $arParams['filter'];
        $select = empty($arParams['select']) ? ['*'] : $arParams['select'];

        $invoices = CRest::call(
            'crm.item.list',
            [
                'entityTypeId' => 31,
                'order' => $order,
                'filter' => $filter,
                'select' => $select,
            ]
        );

        return $invoices;
    }

    /**
     * '>DATE_CREATE' => '2019-10-01T00:00:00'
     * '<DATE_CREATE' => '2019-10-31T23:59:59'
     * @param $dateRange
     * @return string[]
     */
    public static function prepareDateRangeFilter($dateRange)
    {
        $explodedDate = explode(' - ', $dateRange);
        $dateFrom = date_create($explodedDate[0]);
        $dateTo = date_create($explodedDate[1]);

        $filter = array(
            '<DATE_CREATE' => date_format($dateTo, "Y-m-d\TH:i:s"),
            '>DATE_CREATE' => date_format($dateFrom, "Y-m-d\TH:i:s"),
        );

        return $filter;
    }

    /**
     * '>createdDate' => '2019-10-01T00:00:00'
     * '<createdDate' => '2019-10-31T23:59:59'
     * @param $dateRange
     * @return string[]
     */
    public static function prepareInvoicesDateFilter($dateRange)
    {
        $explodedDate = explode(' - ', $dateRange);
        $dateFrom = date_create($explodedDate[0]);
        $dateTo = date_create($explodedDate[1]);

        $filter = array(
            '<createdTime' => date_format($dateTo, "Y-m-d\TH:i:s"),
            '>createdTime' => date_format($dateFrom, "Y-m-d\TH:i:s"),
        );

        return $filter;
    }
}