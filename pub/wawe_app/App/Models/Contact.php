<?php

namespace App\Models;

use PDO;

/**
 * Contact model
 */
class Contact extends \Core\Model
{
    public static $table = 'wave_contacts';

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

    public static function add($arParams)
    {
        $keys = implode(', ', array_keys($arParams));
        $keysMark = ':'.implode(', :', array_keys($arParams));

        $db = static::getDB();
        $sql = 'INSERT INTO '.static::$table.' ('.$keys.') VALUES ('.$keysMark.')';
        $stmt= $db->prepare($sql);
        $stmt->execute($arParams);
    }

    public static function getById($id)
    {
        $result = [];
        $db = static::getDB();
        $sql = 'SELECT * From '.static::$table.' WHERE contact_bitrix_id = "'.$id.'"';
        $stmt = $db->query($sql, PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            $result = $row;
        }
        return $result;
    }

}
