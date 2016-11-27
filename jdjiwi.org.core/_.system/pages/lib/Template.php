<?php

namespace Jdjiwi\Pages;

class Template {

    static private $arTemplates = null;

    static public function set($t) {
        self::$arTemplates = $t;
    }

    static public function get($id) {
        return isset(self::$arTemplates[$id]) ? self::$arTemplates[$id] : null;
    }

}
