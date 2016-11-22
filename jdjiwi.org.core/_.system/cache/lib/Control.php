<?php

namespace Jdjiwi\Cache;

class Control {

    private static $page = false;
    private static $data = false;

    // управление кеширование
    // вернуть режим кеширование
    static public function isNoPages() {
        return self::$page;
    }

    static public function isNoData() {
        return self::$data;
    }

    // установить режим кеширование
    static public function setPages($s = true) {
        self::$page = (bool) $s;
    }

    static public function setData($s = true) {
        self::$data = (bool) $s;
    }

}
