<?php

namespace Jdjiwi;

Loader::library('core:input/Get');
Loader::library('core:input/Post');
Loader::library('core:input/Files');
Loader::library('core:input/Ip');
Loader::library('core:input/Header');
Loader::library('core:input/Url');
Loader::library('core:input/Param');
Loader::library('core:input/function');
Loader::library('core:traits/StaticRegistry');

class Input {

    use Traits\StaticRegistry;

//    private $get;
//    private $post;
//    private $files;
//    private $ip;
//    private $header;
//    private $url;
//    static private $userAgent = null;
//    function __construct() {
//        $this->get = new Input\Get();
//        $this->post = new Input\Get();
//        $this->files = new Input\Files();
//        $this->ip = new Input\Ip();
//        $this->header = new Input\Header();
//        $this->url = new Input\Url();
//    }

    static public function get() {
        return self::register('\Jdjiwi\Input\Get');
    }

    static public function post() {
        return self::register('\Jdjiwi\Input\Post');
    }

    static public function files() {
        return self::register('\Jdjiwi\Input\Files');
    }

    static public function ip() {
        return self::register('\Jdjiwi\Input\Ip');
    }

    static public function header() {
        return self::register('\Jdjiwi\Input\Header');
    }

    static public function url() {
        return self::register('\Jdjiwi\Input\Url');
    }

    static public function param() {
        return self::register('\Jdjiwi\Input\Param');
    }

    static public function userAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;
    }

}
