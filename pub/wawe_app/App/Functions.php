<?php

function p($item)
{
    echo "<pre>";
    print_r($item);
    echo "</pre>";
}

function GetMessage($code)
{
    $lang = DEFAULT_LANG;
    if(!empty($_REQUEST['LANG']) && in_array($_REQUEST['LANG'], LIST_LANGS)) {
        $lang = $_REQUEST['LANG'];
    }

    $MESS = [];
    $langFile = __DIR__.'/lang/'.$lang.'.php';
    if(file_exists($langFile)) {
        include $langFile;
    } else {
        $langFile = __DIR__.'/lang/'.DEFAULT_LANG.'.php';
        include $langFile;
    }

    if(!empty($MESS[$code])) {
        return $MESS[$code];
    }
    return '';
}

function generatePassword($length = 8){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}