<?php

namespace App\Util;

class UtfUtil
{
    public static function utf8ize($d) {
        if (!is_array($d) && !is_object($d)) {
            return utf8_encode($d);
        }
        foreach ($d as &$v) {
            $v = static::utf8ize($v);
        }
        return $d;
    }
}