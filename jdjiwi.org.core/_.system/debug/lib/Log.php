<?php

namespace Jdjiwi;

use Jdjiwi\Pages,
    Jdjiwi\FileSystem\Utility;

//Loader::library('core:Time');
Modul::load('fileSystem');

class Log {

    private static $sqlTime = 0;
    private static $sqlCount = 0;
    private static $arLog = array('log' => array());
    private static $startTime = null;

    /* инициализация */

    // инициализация работы
    static public function init() {
        self::$startTime = Time::microtime();
    }

    static public function destroy() {
        self::$arLog = array();
    }

    /* отладка memory */

    protected static function round($t) {
        return round($t, 3);
    }

    // количетсво потраченной пямяти
    static public function memory() {
        self::push('log', 'memory: ' . self::round(memory_get_usage() / 1024 / 1024));
    }

    static public function modul($modul) {
        if (Debug::isModul()) {
            self::push('modul', $modul . ': ' . self::round(memory_get_usage() / 1024 / 1024));
        }
    }

    /* ошибки error */

    private static function processingMessage(&$e) {
        if (is_a($e, 'Exception')) {
            $e = Exception::parseTrace((string) $e);
        }
    }

    // добавить в лог ошибок php
    static public function error($message) {
        if (Debug::isError()) {
            self::processingMessage($message);
//            if (!Debug::isShutdown()) {
//                echo '<pre>' . $message . '</pre>';
//            }
            self::push('log', $message . PHP_EOL);
        }
    }

    // добавить в лог ошибок php
    static private function push($type, $message) {
        self::$arLog[$type][] = $message;
    }

    static public function add($message) {
        if (Debug::isSql()) {
            self::processingMessage($message);
            self::push('log', $message);
        }
    }

    /* ошибки sql */

    // добавить в лог запросов к базе
    static public function sql($message = 'SELECT 1', $time = null) {
        if (Debug::isSql()) {
            $message = ( ++self::$sqlCount) . ' ' . self::round($time) . " " . Str::specialchars($message);
            if (class_exists('cPages', false)) {
                $page = Pages::getItem();
                if (Pages::isMain($page)) {
                    $message .= " [{$page}]";
                } else {
                    $main = Pages::getMain($page);
                    $message .= " [{$main}] [{$page}]";
                }
            }
            self::push('log', $message);
            self::$sqlTime += $time;
        }
    }

    // добавить в лог запросов к базе
    static public function explain($message) {
        if (Debug::isExplain()) {
            self::push('log', Str::specialchars($message));
        }
    }

    /* лог */

    // показ лога
    static public function message() {
        $message = '<pre id="coreDebugLog">'
                . PHP_EOL . '<b>RUN/INIT</b> = ' . self::round(Time::microtime() - self::$startTime)
                . '/' . self::round(self::$startTime - Time::microtime(cTimeInit))
                . PHP_EOL . '<b>TIME</b> = ' . self::round(Time::microtime() - Time::microtime(cTimeInit));

        if (Debug::isSql()) {
            $message .= PHP_EOL . '<b>SQL_TIME(' . self::$sqlCount . ')</b> = ' . self::round(self::$sqlTime);
        }
        if (defined('ERROR_HOST')) {
            $message .= PHP_EOL . '<b>Хост ' . $_SERVER['HTTP_HOST'] . ' не был найден</b>';
        }
        foreach (self::$arLog as $key => $value) {
            if ($key !== 'log') {
                $message .= PHP_EOL . PHP_EOL . $key . '.log:';
            }
            $message .= PHP_EOL . implode(PHP_EOL, $value);
        }
        return $message . '</pre>';
    }

    // запись ошибок в файл
    static public function addError($message) {
        self::error($message);
        try {
            $message = PHP_EOL . date("Y-m-d H:i:s (T): ") . ' ' . $message;
            $file = Config::get('path.data') . 'errorLog/' . date('Y-m') . '/'. date('Y-m-d_H') . '.log';
            Utility::checkPath($file);
            if (!($f = fopen($file, 'a'))) {
                throw new FileSystem\Exception('запись не произведена', $file);
            }
            fwrite($f, strip_tags(trim($message)) . PHP_EOL . PHP_EOL . PHP_EOL);
            fclose($f);
        } catch (\cException $e) {
            $e->error('Запись в лог не доступна');
        }
    }

}
