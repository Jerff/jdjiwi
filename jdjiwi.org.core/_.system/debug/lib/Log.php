<?php

namespace Jdjiwi;

Loader::library('core:time/cTime');
Modul::load('file');

class Log {

    private static $sqlTime = 0;
    private static $sqlCount = 0;
    private static $arLog = array('log' => array());
    private static $startTime = null;

    /* инициализация */

    // инициализация работы
    static public function init() {
        self::$startTime = \cTime::microtime();
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
        self::add('log', 'memory: ' . self::round(memory_get_usage() / 1024 / 1024));
    }

    static public function modul($modul) {
        if (Debug::isModul()) {
            self::add('modul', $modul . ': ' . self::round(memory_get_usage() / 1024 / 1024));
        }
    }

    /* ошибки error */

    private static function processingMessage(&$e) {
        if (is_a($e, 'Exception')) {
            $e = \cException::parseTrace((string) $e);
        }
    }

    // добавить в лог ошибок php
    static public function error($message) {
        if (Debug::isError()) {
            self::processingMessage($message);
//            if (!Debug::isShutdown()) {
//                echo '<pre>' . $message . '</pre>';
//            }
            self::add('log', $message . PHP_EOL);
        }
    }

    // добавить в лог ошибок php
    static private function add($type, $message) {
        self::$arLog[$type][] = $message;
    }

    static public function log($message) {
        if (Debug::isSql()) {
            self::processingMessage($message);
            self::add('log', $message);
        }
    }

    /* ошибки sql */

    // добавить в лог запросов к базе
    static public function sql($message = 'SELECT 1', $time = null) {
        if (Debug::isSql()) {
            $message = ( ++self::$sqlCount) . ' ' . self::round($time) . " " . \cString::specialchars($message);
            if (class_exists('cPages', false)) {
                $page = \cPages::getItem();
                if (\cPages::isMain($page)) {
                    $message .=" [{$page}]";
                } else {
                    $main = \cPages::getMain($page);
                    $message .=" [{$main}] [{$page}]";
                }
            }
            self::add('log', $message);
            self::$sqlTime += $time;
        }
    }

    // добавить в лог запросов к базе
    static public function explain($message) {
        if (Debug::isExplain()) {
            self::add('log', \cString::specialchars($message));
        }
    }

    /* лог */

    // показ лога
    static public function message() {
        $message = '<pre id="coreDebugLog">'
                . PHP_EOL . '<b>RUN/INIT</b> = ' . self::round(\cTime::microtime() - self::$startTime)
                . '/' . self::round(self::$startTime - \cTime::microtime(cTimeInit))
                . PHP_EOL . '<b>TIME</b> = ' . self::round(\cTime::microtime() - \cTime::microtime(cTimeInit));

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
    static public function errorLog($message) {
        self::error($message);
        try {
            $message = PHP_EOL . date("Y-m-d H:i:s (T): ") . ' ' . $message;
            $dir = Config::get('path.data') . 'errorLog/' . date('Y-m') . '/';
            \cFileSystem::mkdir($dir);
            $file = $dir . date('Y-m-d (H)') . '.log';
            \cFile::isWritable($file);
            if (!($f = fopen($file, 'a'))) {
                throw new \cFileException('запись не произведена', $file);
            }
            fwrite($f, strip_tags(trim($message)) . PHP_EOL . PHP_EOL . PHP_EOL);
            fclose($f);
        } catch (\cException $e) {
            $e->error('Запись в лог не доступна');
        }
    }

}
