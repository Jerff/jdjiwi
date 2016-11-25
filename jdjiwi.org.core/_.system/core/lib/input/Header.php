<?php

namespace Jdjiwi\Input;

class cInputHeader {

    static private $arHeader = null;

    static private function init() {
        if (!empty(self::$arHeader))
            return;

        if (function_exists('apache_request_headers')) {
            self::$arHeader = apache_request_headers();
        } else {
            self::$arHeader = array(
                'Content-Type' => isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : @getenv('CONTENT_TYPE')
            );
            foreach ($_SERVER as $key => $val) {
                if (strncmp($key, 'HTTP_', 5) === 0) {
                    $k = str_replace(array(' ', '_'), array('-', ' '), ucwords(strtolower(substr($key, 5))));
                    self::$arHeader[$k] = $_SERVER[$key];
                }
            }
        }
    }

    static function is($n) {
        $this->init();
        return isset(self::$arHeader[$n]);
    }

    static function get($n, $d = null) {
        $this->init();
        return get(self::$arHeader, $n, $d);
    }

    static function all() {
        $this->init();
        return self::$arHeader;
    }

}
