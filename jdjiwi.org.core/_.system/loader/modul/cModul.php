<?php

cLoader::library('loader/modul/cModulException');
cModul::load('debug');
cModul::load('compile');

/*
 * загрузка модулей
 */

class cModul extends cLoaderCompile {

    static private $isCompile = false;
    static private $item = null;
    static private $mItem = array();
    static private $mLoad = array();

    static public function isCompile() {
        return empty(self::$mItem) and self::$isCompile;
    }

    static public function setItem($modul) {
        if (!empty(self::$item)) {
            self::$mItem[] = self::$item;
        }
        self::$item = $modul;
    }

    static public function getItem() {
        return self::$item;
    }

    static public function freeItem() {
        if (empty(self::$mItem)) {
            self::$item = null;
        } else {
            self::$item = array_pop(self::$mItem);
        }
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
            if (self::isCompile()) {
                cCompile::php()->load('modul', $modul . '/' . $file . '.php');
            } else {
                require_once($modul . '/' . $file . '.php');
            }
            self::setHistory($file);
        } catch (Exception $e) {
            throw new cModulException('Модуль "' . $modul . '" не найден', 0, $e);
            return self::$mLoad[$hash] = false;
        }
        self::setItem(null);
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

    static private function cron($command) {
        try {
            list($modul, $file) = exlode(':', $command);
            self::load($modul);
            self::loadFile($modul, 'cron/' . $file);
            return true;
        } catch (Exception $e) {
            throw new cModulException('Команда крона "' . $command . '" не найдена', 0, $e);
            return false;
        }
    }

    static public function config($file) {
        if (empty(self::getItem())) {
            throw new cModulException('попытка подключения конфигурации вне модуля', 0, $e);
        } else {
            return self::loadFile(self::getItem(), 'config/' . $file);
        }
    }

}

?>