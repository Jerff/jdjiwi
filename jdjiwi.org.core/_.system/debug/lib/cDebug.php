<?php

class cDebug {

    private static $isError = true;
    private static $isModul = false;
    private static $isAjax = false;
    private static $isSql = false;
    private static $isExplain = false;
    private static $isSqlLog = true;
    private static $isShutdown = false;

    // прекращение отладки
    static public function disable() {
        self::setError(false);
        self::setModul(false);
        self::setAjax(false);
        self::setSql(false);
        self::setExplain(false);
        cLog::destroy();
    }

    static public function init() {
        self::setError(cConfig::get('debug.error'));
        self::setModul(cConfig::get('debug.modul'));
        self::setAjax(cConfig::get('debug.ajax'));
        self::setSql(cConfig::get('debug.sql'));
        self::setExplain(cConfig::get('debug.sql.explain'));
    }

    /* отладка Error */

    // отладка ошибок php
    // вернуть режим отладки ошибок php
    static public function isError() {
        return self::$isError;
    }

    // установить режим отладки ошибок php
    static public function setError($status = true) {
//        if ($status) {
//            error_reporting(E_ALL);
//        } else {
//            error_reporting(0);
//        }
        self::$isError = (bool) $status;
    }

    /* отладка Error */


    /* отладка Modul */

    static public function isModul() {
        return self::$isModul;
    }

    // установить режим отладки ошибок php
    static public function setModul($status = true) {
        self::$isModul = (bool) $status;
    }

    /* отладка Error */



    /* отладка Ajax */

    // показывать лог скриптов
    static public function isAjax() {
        return self::$isAjax;
    }

    static public function setAjax($status = true) {
        self::$isAjax = (bool) $status;
    }

    /* отладка Ajax */



    /* отладка Sql */

    // вернуть режим отладки sql запросов к базе
    static public function isSql() {
        return (self::$isSql and self::$isSqlLog) and ! self::$isShutdown;
    }

    // установить режим отладки sql запросов к базе
    static public function setSql($status = true) {
        self::$isSql = (bool) $status;
    }

    static public function sqlOn() {
        self::$isSqlLog = true;
    }

    static public function sqlOff() {
        self::$isSqlLog = false;
    }

    /* /отладка Sql */



    /* отладка Sql explain */

    // отладка sql explain
    // вернуть режим отладки оптимизации sql запросов к базе
    static public function isExplain() {
        return self::$isExplain;
    }

    // установить режим отладки оптимизации sql запросов к базе
    static public function setExplain($status = true) {
        self::$isExplain = (bool) $status;
    }

    /* /отладка Sql explain */



    /*  завершение работы */

    // показывать ли лог или нет
    static public function isView() {
        return self::isError() or self::isSql() or self::isExplain();
    }

    static public function shutdown() {
        if (self::isView()) {
            echo cLog::message();
        }
    }

}
