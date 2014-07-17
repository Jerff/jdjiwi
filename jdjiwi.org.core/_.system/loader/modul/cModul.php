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

    static public function setHistory($file, $type) {
        self::$mLoad[$file .= '/' . $type] = true;
        cLoader::setHistory(__CLASS__ . '::' . $file);
    }

    static private function loadFile($modul, $file) {
        if (empty($modul) or ! is_string($modul)) {
            throw new cModulException('Не указано имя модуля');
        }
        if (preg_match('#[^a-z0-9:._]#iS', $modul)) {
            throw new cModulException(sprintf('Название модуля "%s" не корректно', $modul));
        }
        self::$item = $modul = str_replace(':', '/', $modul);
        if (isset(self::$mLoad[$modul])) {
            return self::$mLoad[$modul];
        }
        try {
            self::setHistory($modul, $file);
            if (self::$isCompile) {
                cCompile::php()->load('modul', $modul . '/' . $file . '.php');
            } else {
                require_once($modul . '/' . $file . '.php');
            }
        } catch (Exception $e) {
            throw new cModulException('Модуль "' . $modul . '" не найден', 0, $e);
            return self::$mLoad[$modul] = false;
        }
        return self::$mLoad[$modul] = true;
    }

    static public function load($modul) {
        return self::loadFile($modul, 'include');
    }

    static public function call($modul) {
        self::$isCompile = true;
        return self::loadFile($modul, 'call');
    }

    static private function config($file) {
        require_once(self::$item . '/config/' . $file . '.php');
    }

}

?>