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

    static public function compileInit() {
        self::$isCompile = true;
    }

    static public function setHistory($file) {
        self::$mLoad[$file] = true;
        cLoader::setHistory(__CLASS__ . $file);
    }

    static public function load($modul) {
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
            if (self::$isCompile) {
                cCompile::php()->load('modul', $modul . '/include.php');
            } else {
                require_once($modul . '/include.php');
            }
        } catch (Exception $e) {
            throw new cModulException('Модуль "' . $modul . '" не найден', 0, $e);
            return self::$mLoad[$modul] = false;
        }
        return self::$mLoad[$modul] = true;
    }

    static private function config($file) {
        require_once(self::$item . '/config/' . $file . '.php');
    }

}

?>