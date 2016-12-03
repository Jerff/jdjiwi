<?php

namespace Jdjiwi;

//use Jdjiwi\Compile\Php;

//Loader::library('loader:Exception');

/*
 * загрузка модулей
 */

class Modul {

    static private $isCompile = false;
    static private $item = null;
    static private $arItem = array();
    static private $arModul = array();

    static public function isCompile() {
        return empty(self::$arItem) and self::$isCompile;
    }

    static public function setItem($modul) {
        if (!empty(self::$item)) {
            self::$arItem[] = self::$item;
        }
        self::$item = $modul;
    }

    static public function getItem() {
        return self::$item;
    }

    static public function freeItem() {
        if (empty(self::$arItem)) {
            self::$item = null;
        } else {
            self::$item = array_pop(self::$arItem);
        }
    }

    static private function loadFile($modul, $file) {
        if (empty($modul) or ! is_string($modul)) {
            throw new Modul\Exception('Не указано имя модуля');
        }
        if (preg_match('#[^a-z0-9:._]#iS', $modul)) {
            throw new Modul\Exception(sprintf('Название модуля "%s" не корректно', $modul));
        }
        $hash = $modul . '/' . $file;
        if (isset(self::$arModul[$hash])) {
            return self::$arModul[$hash];
        }
        self::setItem($modul);
        try {
//            if (self::isCompile()) {
//                self::setHistory($hash);
//                $res = Php::load('modul', $hash . '.php');
//            } else {
            $res = require_once($hash . '.php');
//            };
            if (empty($res)) {
                $res = true;
            }
        } catch (Exception $e) {
            throw new Modul\Exception('Модуль "' . $modul . '" не найден', 0, $e);
            return self::$arModul[$hash] = false;
        }
        self::freeItem();
        return self::$arModul[$hash] = $res;
    }

    static public function load($modul, $noCompile = false) {
        if (class_exists('\Jdjiwi\Log', false)) {
            Log::modul($modul);
        }
        if ($noCompile && defined('isCompile')) {
            return true;
        }
        return self::loadFile($modul, 'include');
    }

    static public function call($modul) {
        self::$isCompile = true;
        Log::add('host: ' . Config::get('host'));
        Log::add('run: ' . cApplication);
        self::load($modul);
        return self::loadFile($modul, 'call');
    }

    static private function cron($command) {
        try {
            list($modul, $file) = exlode(':', $command);
            self::load($modul);
            self::loadFile($modul, 'cron/' . $file);
            return true;
        } catch (\Exception $e) {
            throw new Modul\Exception(sprintf('Команда крона "%s" не найдена', $command), 0, $e);
            return false;
        }
    }

    static public function config($file) {
        if (empty(self::getItem())) {
            throw new Modul\Exception('попытка подключения конфигурации вне модуля', 0, $e);
        } else {
            return self::loadFile(self::getItem(), 'config/' . $file);
        }
    }

}
