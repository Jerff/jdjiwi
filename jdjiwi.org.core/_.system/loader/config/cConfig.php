<?php

class cConfig {

    const path = '_.config/';

    static private $mData = array();

    static public function pre() {
        echo '<pre>';
        print_r(self::$mData);
        echo '</pre>';
    }

    static public function path($name) {
        return cSoursePath . self::path . $name . '.php';
    }

    static public function load($name) {
        self::set($name, require(self::path($name)));
    }

    static public function set($name, $data) {
        foreach ($data as $key => $value) {
            self::$mData[$name . '.' . $key] = $value;
        }
    }

    static public function get($name) {
        return isset(self::$mData[$name]) ? self::$mData[$name] : null;
    }

}

?>