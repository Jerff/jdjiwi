<?php

cLoader::library('loader/modul/cModulException');
cModul::load('debug');
cModul::load('compile');

/*
 * загрузка модулей
 */

class cModul {

    static private $isCompile = false;
    static private $mLoad = array();
    static private $item = null;

    static public function setHistory($file) {
        cLoader::setHistory(__CLASS__ . '::' . self::$item . '::' . $file);
    }

    static public function setItem($modul) {
        self::$item = $modul;
    }

    static public function setLoad($modul, $file) {
        self::$mLoad[$modul . $file] = true;
    }

    static private function loadFile($modul, $file) {
        if (empty($modul) or ! is_string($modul)) {
            throw new cModulException('Не указано имя модуля');
        }
        if (preg_match('#[^a-z0-9:._]#iS', $modul)) {
            throw new cModulException(sprintf('Название модуля "%s" не корректно', $modul));
        }
        self::setItem($modul);
        $hash = $modul . $file;
        if (isset(self::$mLoad[$hash])) {
            return self::$mLoad[$hash];
        }
        try {
            self::setHistory($file);
            if (self::$isCompile) {
                cCompile::php()->load('modul', $modul . '/' . $file . '.php');
            } else {
                require_once($modul . '/' . $file . '.php');
            }
        } catch (Exception $e) {
            throw new cModulException('Модуль "' . $modul . '" не найден', 0, $e);
            return self::$mLoad[$hash] = false;
        }
        return self::$mLoad[$hash] = true;
    }

    static public function load($modul) {
        return self::loadFile($modul, 'include');
    }

    static public function call($modul) {
        self::$isCompile = true;
        cLog::log('run: ' . cApplication);
        self::load($modul);
        return self::loadFile($modul, 'call');
    }

    static private function cron($file) {
        require_once(str_replace(':', self::$item . '/cron/', $file . '.php'));
    }

    static public function config($file) {
        return self::loadFile(self::$item, 'config/' . $file);
    }

}

?>