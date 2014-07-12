<?php

class cConfig {

    const path = '_.config/';

    static private $mData = array();
    static private $host = null;

    static public function pre() {
        echo '<pre>';
        print_r(self::$mData);
        echo '</pre>';
    }

    static public function path($name) {
        if (is_file(cSoursePath . self::path . self::$host . '/' . $name . '.php')) {
            return cSoursePath . self::path . self::$host . '/' . $name . '.php';
        } else {
            return cSoursePath . self::path . $name . '.php';
        }
    }

    static private function init($name, $data) {
        if ($name === 'host') {
            foreach ($data as $host => $data) {
                if ($_SERVER['HTTP_HOST'] === $data['url']) {
                    self::$host = $host;
                    break;
                }
            }
        }
        return $data;
    }

    static public function load($name) {
        foreach (self::init($name, require(self::path($name))) as $key => $value) {
            self::$mData[$name . '.' . $key] = $value;
        }
    }

    static public function set($name, $data) {
        foreach (self::init($name, $data()) as $key => $value) {
            self::$mData[$name . '.' . $key] = $value;
        }
    }

    static public function get($name) {
        return isset(self::$mData[$name]) ? self::$mData[$name] : null;
    }

}

?>