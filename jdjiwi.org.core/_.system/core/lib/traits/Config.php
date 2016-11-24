<?php

namespace Jdjiwi\Traits;

trait Config {

    private $arConfig = array();

    public function __construct($config = null) {
        if (empty($config)) {
            $this->set($this->init());
        } else {
            $this->set($config);
        }
    }

    protected function set($config) {
        $this->arConfig = $config;
    }

    abstract protected function init();

    public function is($name) {
        return isset($this->arConfig[$name]);
    }

    public function replace($search, $replace) {
        return str_replace($search, $replace, $this->arConfig);
    }

    public function __get($name) {
        return get($this->arConfig, $name);
    }

    public function __call($name, $arguments) {
        if (isset($this->arConfig[$name])) {
            $class = get_class($this);
            return new $class($this->arConfig[$name]);
        } else {
            return $this->__get($name);
        }
    }

}
