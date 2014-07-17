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

    static public function getFiles($name) {
        $mFile = array(
            $name . '.php'
        );
        if (self::$host and is_file(cSoursePath . self::path . self::$host . '/' . $name . '.php')) {
            $mFile[] = self::$host . '/' . $name . '.php';
        }
        return $mFile;
    }

    static public function path($file) {
        return cSoursePath . self::path . $file;
    }

    static private function init($name, $data) {
        if ($name === 'host') {
            foreach ($data as $host => $data) {
                if (strpos($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], $data['url']) === 0) {
                    self::$host = $host;
                    break;
                }
            }
        }
        return $data;
    }

    static public function setHistory($file) {
        cLoader::setHistory(__CLASS__ . '::' . $file);
    }

    static public function load($name) {
        foreach (self::getFiles($name) as $file) {
            self::setHistory($file);
            foreach (self::init($name, require(self::path($file))) as $key => $value) {
                self::$mData[$name . '.' . $key] = $value;
            }
        }
    }

    static public function set($name, $file, $data) {
        self::setHistory($file);
        foreach (self::init($name, $data()) as $key => $value) {
            self::$mData[$name . '.' . $key] = $value;
        }
    }

    static public function get($name) {
        return isset(self::$mData[$name]) ? self::$mData[$name] : null;
    }

}

?>