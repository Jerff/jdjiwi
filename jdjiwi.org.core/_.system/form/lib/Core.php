<?php

namespace Jdjiwi\Form;

class Core extends Register {

    // конфигурация
    public function config() {
        return $this->register('\Jdjiwi\Form\Config', self::collective);
    }

    // ошибки
    public function error() {
        return $this->register('\Jdjiwi\Form\Error', self::collective);
    }

    // проверка валидности форм
    public function security() {
        return $this->register('cFormSecurity', self::collective);
    }

}
