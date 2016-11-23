<?php

namespace Jdjiwi\Traits;

trait StaticRegistry {

    static private $arRegister = array();

    static protected function &register($class) {
        if (!isset(self::$arRegister[$class])) {
            self::$arRegister[$class] = new $class();
        }
        return self::$arRegister[$class];
    }

}
