<?php

// делегатор для cmfCacheDriver
class cCacheDelegation {

    // кеширование данных
    static public function set($n, $v, $tags = null, $time = cCacheConfig::TIME) {
        if (cCache::isNoData())
            return false;
        cLog::log('cache.set ' . $n);
        cCache::driver()->set($n, $v, $tags, $time * 60);
    }

    static public function get($n) {
        if (cCache::isNoData())
            return false;
        cLog::log('cache.get ' . $n);
        return cCache::driver()->get($n);
    }

    static public function delete($n) {
        if (cCache::isNoData())
            return false;
        cLog::log('cache.delete ' . $n);
        cCache::driver()->delete($n);
    }

    // кеширование данных  + добавляется url
    static private function getPath() {
        static $url = null;
        if (!$url)
            $url = cInput::url()->path();
        return $url;
    }

    static public function setRequest($n, $v, $tags = null, $time = cCacheConfig::TIME) {
        self::set($n . self::getPath(), $v, $tags, $time);
    }

    static public function getRequest($n) {
        return self::get($n . self::getPath());
    }

    static public function delRequest($n) {
        self::delete($n . self::getPath());
    }

    // кеш данные по имени и параметрам
    static public function setParam($n, $p, $v, $tags = null, $time = cCacheConfig::TIME) {
        self::set($n . serialize($p), $v, $tags, $time);
    }

    static public function getParam($n, $p) {
        return self::get($n . serialize($p));
    }

    static public function delParam($n, $p) {
        self::delete($n . serialize($p));
    }

    static public function deleteTime() {
        cCache::driver()->deleteTime();
    }

    static public function deleteTag($tags) {
        cCache::driver()->deleteTag($tags);
    }

    static public function clear() {
        cCache::driver()->clear();
    }

}

?>