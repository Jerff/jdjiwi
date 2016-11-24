<?php

namespace Jdjiwi\Traits;

trait Settings {

    private $arSettings = array();
    private $arReplace = array();
    private $arDelete = array();

    public function replace($s, $r) {
        if (isset($this->arReplace[$r])) {
            $this->replace($s, $this->arReplace[$r]);
        } else {
            $this->arReplace[$s] = $r;
        }
    }

    public function delete($s, $r) {
        $this->arDelete[$s] = $r;
        unset($this->arSettings[$s], $this->arReplace[$s]);
    }

    public function get($n) {
        return get($this->arSettings, $n);
    }

    public function get2($n, $n2) {
        return get2($this->arSettings, $n, $n2);
    }

    public function get3($n, $n2, $n3) {
        return get3($this->arSettings, $n, $n2, $n3);
    }

    public function __get($name) {
        return get($this->arSettings, $name);
    }

    public function is($name) {
        return isset($this->arSettings[$name]);
    }

    // установить
    protected function set($k, $v) {
        $this->arSettings[get($this->arReplace, $k, $k)] = $v;
    }

    // вернуть список
    public function &all() {
        return $this->arSettings;
    }

    // настройка
    public function &__call($name, $arguments) {
        if (isset($this->arDelete[$name])) {
            return $this;
        }
        if (empty($arguments)) {
            $this->set($name, true);
        } else if (count($arguments) == 1) {
            $this->set($name, $arguments[0]);
        } else {
            $this->set($name, $arguments);
        }
        return $this;
    }

}
