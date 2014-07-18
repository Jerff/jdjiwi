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
        self::$mLoad[$file] = true;
        cLoader::setHistory(__CLASS__ . '::' . self::$item . '::' . $file);
    }

    static public function setItem($modul) {
        self::$item = $modul;
        ;
    }

    static private function loadFile($modul, $file) {
        if (empty($modul) or ! is_string($modul)) {
            throw new cModulException('Не указано имя модуля');
        }
        if (preg_match('#[^a-z0-9:._]#iS', $modul)) {
            throw new cModulException(sprintf('Название модуля "%s" не корректно', $modul));
        }
        self::setItem($modul);
        if (isset(self::$mLoad[$modul])) {
            return self::$mLoad[$modul];
        }
        try {
            $file = $modul . '/' . $file . '.php';
            if (self::$isCompile) {
                cCompile::php()->load('modul', $file);
            } else {
                require_once($file);
            }
            self::setHistory($file);
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
        cLog::log('run: ' . cApplication);
        return self::loadFile($modul, 'call');
    }

    static private function cron($file) {
        require_once(str_replace(':', self::$item . '/cron/', $file . '.php'));
    }

    static private function config($file) {
        self::setHistory(self::$item . '/config/' . $file . '.php');
        require_once(self::$item . '/config/' . $file . '.php');
    }

}

?>