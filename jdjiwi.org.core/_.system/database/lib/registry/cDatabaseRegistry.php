<?php

abstract class cDatabaseRegistry {

    private $mRegister = array();
    private $parent = false;

    protected function &register($class) {
        if (!isset($this->mRegister[$class])) {
            $this->mRegister[$class] = new $class();
            if (is_subclass_of($this->mRegister[$class], __CLASS__)) {
                $this->mRegister[$class]->initDb($this);
            }
        }
        return $this->mRegister[$class];
    }

    // инициализация регистра в подчиненных классах
    public function initDb(&$parent) {
        $this->parent = $parent;
    }

    protected function DB() {
        return $this->parent;
    }

}
