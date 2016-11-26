<?php

namespace Jdjiwi;

Loader::library('core:input/function');
Loader::library('core:input/Get');
Loader::library('core:input/Post');
Loader::library('core:input/Files');
Loader::library('core:input/Ip');
Loader::library('core:input/Header');
Loader::library('core:input/Url');

//Loader::library('core:input/Param');

class Input {

    static public function userAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;
    }

}
