<?php

namespace Jdjiwi\Form\Core;

abstract class Register {

    const personal = 1;
    const collective = 2;
    const initialization = 3;

    private $arPersonal = array();
    private $arCollective = array();
    private $form = false;
    private $parent = false;

//    public function __construct() {
//        \Jdjiwi\Log::log('__construct ' . get_class($this));
//    }
//
//    public function __destruct() {
//        \Jdjiwi\Log::log('__destruct ' . get_class($this));
//    }


    public function setForm(&$form) {
        $this->form = $form;
    }

    public function form() {
        return $this->form;
    }

    public function parent() {
    return $this->parent;


    }

protected function &register($class, $type = self::personal) {
    switch ($type) {
        case self::personal:
            if (isset($this->arPersonal[$class])) {
                return $this->arPersonal[$class];
            }
            $object = $this->arPersonal[$class] = new $class();
            break;

        case self::collective:
            if (isset($this->arCollective[$class])) {
                return $this->arCollective[$class];
            }
            $object = $this->arCollective[$class] = new $class();
            break;

        case self::initialization:
            $object = new $class();
            break;

        default:
            throw new \Jdjiwi\Exception('нет такого типа данных', $type);
            break;
    }
    if (is_subclass_of($object, __CLASS__)) {
//            \Jdjiwi\Log::log(get_class($this) .' => '. $type .' => ' . print_r(array_keys($this->mCollective), true));
//            \Jdjiwi\Log::log("\t\t\t\t". get_class($this) .' => '. $type .' => ' . get_class($object));
//            \Jdjiwi\Log::log(print_r(array_keys($this->mCollective), true));
        $object->initRegister($this, $this->form, $this->arCollective);
    }
    return $object;
}

// инициализация регистра в подчиненных классах
public function initRegister(&$parent, &$form, &$mCollective) {
    $this->parent = &$parent;
    $this->form = &$form;
    $this->arCollective = &$mCollective;
    if (is_subclass_of($this, 'cFormElement')) {
        $this->init();
    }
}

}
