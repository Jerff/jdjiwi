<?php

class cConfig {

    const path = '_.config/';

    static private $mData = array();

    static public function pre() {
        echo '<pre>';
        print_r(self::$mData);
        echo '</pre>';
    }

    static public function load($name) {
        $conf = require(cSoursePath . self::path . $name . '.php');
        foreach ($conf as $key => $value) {
            self::$mData[$name . '.' . $key] = $value;
        }
    }

    static public function get($name) {
        return isset(self::$mData[$name]) ? self::$mData[$name] : null;
    }

    static public function set($name, $data) {
        foreach (unserialize($data) as $key => $value) {
            self::$mData[$name . '.' . $key] = $value;
        }
    }

}

?>