<?php

namespace Jdjiwi\Traits;

trait StaticRegistry {

    static private $mRegister = array();

    static protected function &register($class) {
        if (!isset(self::$mRegister[$class])) {
            self::$mRegister[$class] = new $class();
        }
        return self::$mRegister[$class];
    }

}
