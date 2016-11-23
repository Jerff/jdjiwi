<?php

namespace Jdjiwi\Traits;

trait sRegistry {

    private $mRegister = array();
    private $parent = false;

    protected function &register($class) {
        if (empty($this->mRegister[$class])) {
            $this->mRegister[$class] = new $class();
            if (is_subclass_of($this->mRegister[$class], __CLASS__)) {
                $this->mRegister[$class]->initParent($this);
            }
        }
        return $this->mRegister[$class];
    }

    // инициализация регистра в подчиненных классах
    public function initParent(&$parent) {
        $this->parent = $parent;
    }

    protected function parent() {
    return $this->parent;

    }

}
