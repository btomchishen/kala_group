<?php

namespace App\Models;

use PDO;

/**
 * Portal model
 */
class Portal extends \Core\Model
{
    public static $table = 'wawe_list_portals';

    /**
     * Get all the portals as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM '.static::$table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function prepare($arParams)
    {
        $params = [];
        $rq = $arParams;

        if(!empty($rq['portal_domain'])) {
            $params['portal_domain'] = $rq['portal_domain'];
        }
        if(!empty($rq['lang'])) {
            $params['lang'] = $rq['lang'];
        }
        if(!empty($rq['access_token'])) {
            $params['access_token'] = $rq['access_token'];
        }
        if(!empty($rq['refresh_token'])) {
            $params['refresh_token'] = $rq['refresh_token'];
        }
        if(!empty($rq['member_id'])) {
            $params['member_id'] = $rq['member_id'];
        }
        if(!empty($rq['application_token'])) {
            $params['application_token'] = $rq['application_token'];
        }
        if(!empty($rq['status'])) {
            $params['status'] = $rq['status'];
        }
        if(!empty($rq['protocol'])) {
            $params['protocol'] = $rq['protocol'];
        }
        if(!empty($rq['placement'])) {
            $params['placement'] = $rq['placement'];
        }
        if(!empty($rq['placement_options'])) {
            $params['placement_options'] = $rq['placement_options'];
        }
        if(!empty($rq['client_endpoint'])) {
            $params['client_endpoint'] = $rq['client_endpoint'];
        }
        return $params;
    }

    public static function add($arParams)
    {
        $keys = implode(', ', array_keys($arParams));
        $keysMark = ':'.implode(', :', array_keys($arParams));

        $db = static::getDB();
        $sql = 'INSERT INTO '.static::$table.' ('.$keys.') VALUES ('.$keysMark.')';
        $stmt= $db->prepare($sql);
        $stmt->execute($arParams);
    }

    public static function update($arParams, $keyUpdate = 'portal_domain')
    {
        $arKey = [];
        foreach ($arParams as $key => $value) {
            $arKey[] = $key.'=:'.$key;
        }
        $strKey = implode(", ", $arKey);
        $db = static::getDB();
        $table = static::$table;
        $sql = "UPDATE $table SET $strKey WHERE $keyUpdate=:$keyUpdate";
        $stmt= $db->prepare($sql);
        return $stmt->execute($arParams);
    }

    public static function getByDomain($domain)
    {
        $result = [];
        $db = static::getDB();
        $sql = 'SELECT * From '.static::$table.' WHERE PORTAL_DOMAIN = "'.$domain.'"';
        $stmt = $db->query($sql, PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $result = $row;
        }
        return $result;
    }

    public static function getByField($field, $value)
    {
        $result = [];
        $db = static::getDB();
        $sql = 'SELECT * From '.static::$table.' WHERE '.$field.' = "'.$value.'"';
        $stmt = $db->query($sql, PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $result = $row;
        }
        return $result;
    }

    public static function delete($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM ".static::$table." WHERE id=?";
        $stmt= $db->prepare($sql);
        $stmt->execute([$id]);
    }
}
