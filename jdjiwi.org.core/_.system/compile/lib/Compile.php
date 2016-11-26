<?php

namespace Jdjiwi;

Loader::library('compile:Config');
Loader::library('compile:Php');
Loader::library('compile:JsCss');
Loader::library('compile:Update');

class Compile {

    static public function is() {
        return Settings::get('compilde', 'css&js') or 1;
    }

}
