<?php

namespace Jdjiwi\Traits;

trait sRegistry {

    private $arRegister = array();
    private $parent = false;

    protected function &register($class) {
        if (empty($this->arRegister[$class])) {
            $this->arRegister[$class] = new $class();
            if (is_subclass_of($this->arRegister[$class], __CLASS__)) {
                $this->arRegister[$class]->initParent($this);
            }
        }
        return $this->arRegister[$class];
    }

    // инициализация регистра в подчиненных классах
    public function initParent(&$parent) {
        $this->parent = $parent;
    }

    protected function parent() {
    return $this->parent;

    }

}
