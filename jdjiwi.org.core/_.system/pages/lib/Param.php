<?php

namespace Jdjiwi\Pages;

class Param {

    static private $arParam = null;

    static public function set(&$arParam) {
        self::$arParam = $arParam;
    }

    static public function get($id) {
        return isset(self::$arParam[$id - 1]) ? self::$arParam[$id - 1] : null;
    }

    static public function all() {
        return self::$arParam;
    }

    static public function count() {
        return count(self::$arParam);
    }

}
