<?php

namespace Jdjiwi;

class Config extends Loader\Compile {

    const path = '_.config/';

    static private $mData = array();
    static private $host = null;

    static public function pre() {
        echo '<pre>';
        print_r(get_defined_constants(true)['user']);
        print_r(self::$mData);
        echo '</pre>';
    }

    static public function path($file) {
        return self::path . $file;
    }

    static public function getFiles($name) {
        $mFile = array(
            self::path . $name
        );
        if (self::$host and is_file(cSoursePath . self::path(self::$host . '/' . $name) . '.php')) {
            $mFile[] = self::path(self::$host . '/' . $name);
        }
        return $mFile;
    }

    static private function init($name, $data) {
        if ($name === 'host') {
            foreach ($mData = $data as $host => $data) {
                if (strpos($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], $data['url']) === 0) {
                    self::$host = $host;
                    self::set('host', $host);
                    self::set('host.uri', $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    break;
                }
            }
            if (empty(self::$host)) {
                foreach ($mData as $host => $data) {
                    if (isset($data['default'])) {
                        self::$host = $host;
                        self::set('host', $host);
                        self::set('host.uri', $data['url'] . $_SERVER['REQUEST_URI']);
                        define('ERROR_HOST', true);
                        break;
                    }
                }
            }
        }
        return $data;
    }

    static public function load($name) {
        foreach (self::getFiles($name) as $file) {
            foreach (self::init($name, self::file($file)) as $key => $value) {
                self::$mData[$name . '.' . $key] = $value;
            }
            self::setHistory($file);
        }
    }

    static public function set($name, $value) {
        self::$mData[$name] = $value;
    }

    static public function get($name) {
        return isset(self::$mData[$name]) ? self::$mData[$name] : null;
    }

}
