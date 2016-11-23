<?php

\Jdjiwi\Loader::library('core:input/cInputGet');
\Jdjiwi\Loader::library('core:input/cInputPost');
\Jdjiwi\Loader::library('core:input/cInputFiles');
\Jdjiwi\Loader::library('core:input/cInputIp');
\Jdjiwi\Loader::library('core:input/cInputHeader');
\Jdjiwi\Loader::library('core:input/cInputUrl');
\Jdjiwi\Loader::library('core:input/cInputParam');
\Jdjiwi\Loader::library('core:input/function');
\Jdjiwi\Loader::library('trait:StaticRegistry');

class cInput {

    use \Jdjiwi\Traits\StaticRegistry;

//    private $get;
//    private $post;
//    private $files;
//    private $ip;
//    private $header;
//    private $url;
//    static private $userAgent = null;
//    function __construct() {
//        $this->get = new cInputGet();
//        $this->post = new cInputGet();
//        $this->files = new cInputFiles();
//        $this->ip = new cInputIp();
//        $this->header = new cInputHeader();
//        $this->url = new cInputUrl();
//    }

    static public function get() {
        return self::register('cInputGet');
    }

    static public function post() {
        return self::register('cInputPost');
    }

    static public function files() {
        return self::register('cInputFiles');
    }

    static public function ip() {
        return self::register('cInputIp');
    }

    static public function header() {
        return self::register('cInputHeader');
    }

    static public function url() {
        return self::register('cInputUrl');
    }

    static public function param() {
        return self::register('cInputParam');
    }

    static public function userAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;
    }

}
