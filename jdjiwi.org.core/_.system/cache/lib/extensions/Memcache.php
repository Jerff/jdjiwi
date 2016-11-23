<?php

namespace Jdjiwi\Cache\Extensions;

use Jdjiwi\Config,
    Jdjiwi\Loader,
    Jdjiwi\Settings;

Loader::library('cache:extensions/driver/DriverTag');

class Memcache extends Driver\DriverTag {

    private $res = null;
    private $flag = null;

    function __construct() {
        if (!extension_loaded('memcache')) {
            $this->setError();
            return;
        }

        $res = new \Memcache();
        $res->connect(Config::get('cache.memcache.host'), Config::get('cache.memcache.port'));
        $this->setResurse($res);
        $this->setFlag(Settings::get('memcache.compressed') ? MEMCACHE_COMPRESSED : false);

        parent::__construct();
    }

    private function setResurse(&$res) {
        $this->res = $res;
    }

    private function getResurse() {
        return $this->res;
    }

    private function setFlag($flag) {
        $this->flag = $flag;
    }

    private function getFlag() {
        return $this->flag;
    }

    protected function setId($n, $v, $time) {
        $this->getResurse()->set($n, $v, $this->getFlag(), $time);
    }

    protected function getId($n) {
        return $this->getResurse()->get($n);
    }

    protected function deleteId($n) {
        $this->deleteTagById($n);
        $this->getResurse()->delete($n);
    }

    public function clear() {
        $this->getResurse()->flush();
    }

}
