<?php

if (!function_exists('encrypt')) {
    function encrypt($sData)
    {
        $id = (double) $sData * 525325.24;
        return base64_encode($id);
    }
}

if (!function_exists('decrypt')) {
    function decrypt($sData)
    {
        $url_id = base64_decode($sData);
        $id = (double) $url_id / 525325.24;
        return $id;
    }

}

if (!function_exists('has_symbols')) {
    function has_symbols($value){
    return  (1===preg_match('~[-!$==+_|{}:",.]~', $value)) ? true:false;
    }
    }

if (!function_exists('remove_comma')) {
    function remove_comma($value)
    {
        return str_replace(',', '', $value);
    }
}
