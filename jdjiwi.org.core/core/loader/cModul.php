<?php

cLoader::library('loader/cModulException');
cModul::load('debug');
cModul::load('compile');

/*
 * загрузка модулей
 */

class cModul {

    static private $isCompile = false;
    static private $mLoad = array();

    static public function initCompile() {
        self::$isCompile = true;
    }

    static public function load($modul) {
        if (empty($modul) or ! is_string($modul)) {
            throw new cModulException('Не указано имя модуля');
        }
        if (preg_match('#[^a-z0-9:._]#iS', $modul)) {
            throw new cModulException(sprintf('Название модуля "%s" не корректно', $modul));
        }
        $modul = str_replace(':', '/', $modul);
        if (isset(self::$mLoad[$modul])) {
            return self::$mLoad[$modul];
        }
        try {
            if (self::$isCompile) {
                include_once(cCompile::php()->path('modul', $modul . '/include.php'));
            } else {
                include_once($modul . '/include.php');
            }
        } catch (Exception $e) {
            throw new cModulException('Модуль "' . $modul . '"не найден');
            return self::$mLoad[$modul] = false;
        }
        return self::$mLoad[$modul] = true;
    }

}

?>