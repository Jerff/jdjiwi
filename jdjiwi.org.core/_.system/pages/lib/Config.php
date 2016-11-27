<?php

namespace Jdjiwi\Pages;

class Config {

//    private $key = array(
//        'template' => 't',
//        'uri' => 'u',
//        'path' => 'p',
//        'base' => 'b',
//        'noCache' => '!cache',
//    );
    private $arConfig = array();

    public function __construct($arConfig) {
        $this->arConfig = $arConfig;
    }

    public function isNoPage() {
        return empty($this->arConfig['uri']);
    }

    public function __get($name) {
        return get($this->arConfig, $name);
    }

}
