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
    static private $mModul = array();

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
        $hash = $modul . '/' . $file;
        if (isset(self::$mModul[$hash])) {
            return self::$mModul[$hash];
        }
        self::setItem($modul);
        try {
            if (self::isCompile()) {
                self::setHistory($hash);
                $res = cCompile::php()->load('modul', $hash . '.php');
            } else {
                $res = self::file($hash);
            };
            if (empty($res)) {
                $res = true;
            }
        } catch (Exception $e) {
            throw new cModulException(sprintf('Модуль "%s" не найден', $modul), 0, $e);
            return self::$mModul[$hash] = false;
        }
        self::freeItem();
        return self::$mModul[$hash] = $res;
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
            throw new cModulException(sprintf('Команда крона "%s" не найдена', $command), 0, $e);
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