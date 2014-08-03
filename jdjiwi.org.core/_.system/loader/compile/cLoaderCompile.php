<?php

class cLoaderCompile {

    static private $mHistory = array();
    static private $mCompile = array();
    static private $mLoad = array();

    static protected function hash($file) {
        return get_called_class() . '::' . $file;
    }

    /* history */

    static public function setHistory($file) {
        $hash = self::hash($file);
        if (empty(self::$mHistory[$hash])) {
            self::$mLoad[] = $hash;
        }
        self::$mHistory[$hash] = true;
    }

    static public function getIndex() {
        ksort(self::$mHistory);
        return cCrypt::hash(serialize(self::$mHistory));
    }

    static public function isLoad($file) {
        return isset(self::$mHistory[self::hash($file)]);
    }

    /* compile */

    static public function initLoad() {
        self::$mLoad = array();
    }

    static public function getLoadFile() {
        return array_unique(self::$mLoad);
    }

    static public function compile($file, $func) {
        self::$mCompile[$file] = $func;
    }

    /* pre() */

    static public function pre() {
        pre(self::$mHistory, self::$mLoad, self::$mCompile);
    }

    /* fileLoad */

    static protected function file($file) {
        if (self::isLoad($file)) {
            return false;
        }
        if (isset(self::$mCompile[$hash = self::hash($file)])) {
            $hash = self::$mCompile[$hash];
            $res = $hash();
        } else {
            $res = require($file . '.php');
        }
        self::setHistory($file);
        return $res;
    }

}

