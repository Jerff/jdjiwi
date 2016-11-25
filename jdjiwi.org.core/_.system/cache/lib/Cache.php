<?php

namespace Jdjiwi;

use Jdjiwi\Log;

Loader::library('cache:Control');
Loader::library('cache:extensions/Sql');
Loader::library('cache:extensions/SQLite');
Loader::library('cache:extensions/Memcache');

class Cache {

    static public function driver() {
        if (self::$driver) {
            return self::$driver;
        }

        $cache = '\Jdjiwi\Cache\Extensions\\' . self::getDriver(Config::get('cache.driver'));
        $cache = new $cache;
        if (!$cache->isRun()) {
            foreach (Config::get('cache.driver.list') as $d) {
                if ($d !== $driver) {
                    $cache = '\Jdjiwi\Cache\Extensions\\' . self::getDriver($d);
                    $cache = new $cache;
                    if ($cache->isRun())
                        break;
                }
            }
        }
        if (!$cache->isRun()) {
            throw new Exception('нет драйверов кеша');
        }
        return self::$driver = $cache;
    }

    static private function hash($n) {
        return 'cache:' . $time . ':' . (is_array($n) ? implode(':', $n) : $n);
    }

    static public function run($n, $func, $tags = null, $time = null) {
        if (!$arData = self::get($n)) {
            $arData = $func();
            self::set($n, $arData);
        }
        return $arData;
    }

    // кеширование данных
    static public function set($n, $v, $tags = null, $time = null) {
        if (Cache\Control::isNoData())
            return false;
        $n = self::hash($n);
        Log::add('cache.set ' . $n);
        static::driver()->set($n, $v, $tags, is_null($time) ? Jdjiwi\Config::get('cache.default.time') : $time);
    }

    static public function get($n) {
        if (Cache\Control::isNoData())
            return false;
        $n = self::hash($n);
        Log::add('cache.get ' . $n);
        return static::driver()->get($n);
    }

    static public function delete($n) {
        if (Cache\Control::isNoData())
            return false;
        $n = self::hash($n);
        Log::add('cache.delete ' . $n);
        static::driver()->delete($n);
    }

    // кеширование данных  + добавляется url
    static private function getPath() {
        static $url = null;
        if (empty($url)) {
            $url = Input\Url::path();
        }
        return $url;
    }

    static public function runRequest($n, $func, $tags = null, $time = null) {
        if (!$arData = self::getRequest($n)) {
            $arData = $func();
            self::setRequest($n, $arData);
        }
        return $arData;
    }

    static public function setRequest($n, $v, $tags = null, $time = null) {
        self::set(array($n, self::getPath()), $v, $tags, $time);
    }

    static public function getRequest($n) {
        return self::get(array($n, self::getPath()));
    }

    static public function delRequest($n) {
        self::delete(array($n, self::getPath()));
    }

    // кеш данные по имени и параметрам
    static public function setParam($n, $p, $v, $tags = null, $time = null) {
        self::set(array($n, serialize($p)), $v, $tags, $time);
    }

    static public function getParam($n, $p) {
        return self::get(array($n, serialize($p)));
    }

    static public function delParam($n, $p) {
        self::delete(array($n, serialize($p)));
    }

    static public function deleteTime() {
        self::driver()->deleteTime();
    }

    static public function deleteTag($tags) {
        self::driver()->deleteTag($tags);
    }

    static public function clear() {
        self::driver()->clear();
    }

}
