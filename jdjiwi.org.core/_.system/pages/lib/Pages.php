<?php

namespace Jdjiwi\Pages;

use Jdjiwi\Loader;

////Loader::library('pages:cPagesBase');
//Loader::library('pages:Config');
//Loader::library('pages:Param');
//Loader::library('pages:Template');
//Loader::library('pages:Router');

class Pages {

    static private $main = null;
    static private $item = null;
    static private $arPages = null;

//    static public function urlParam() {
//        return cModul::config('cPagesParam');
//    }
    // установка & возвращение имени главной страницы
    static public function setMain($p) {
        self::$main = $p;
        self::$item = $p;
    }

    static public function getMain() {
        return self::$main;
    }

    static public function isMain($p = null) {
        return self::$main === ($p ? $p : self::$item);
    }

    // установка & возвращение имени текущей страницы
    static public function setItem($p) {
        self::$item = $p;
    }

    static public function getItem() {
        return self::$item;
    }

    // установка & возвращение данных шаблона
    static protected function set($arPages) {
        self::$arPages = $arPages;
    }

    static public function config($n) {
        if (empty(self::$arPages[$n]))
            return false;
        return new Pages\Config(self::$arPages[$n]);
    }

//    //cPages::getUrl()
//    //cInput::url()->adress()
//    static public function getUrl() {
//        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//    }
//
//    //cPages::getUrl2()
//    //cInput::url()->host()
//    static public function getUrl2() {
//        return 'http://' . $_SERVER['HTTP_HOST'];
//    }
//
//    //cPages::getUri()
//    //cInput::url()->uri()
//    static public function getUri() {
//        return get($_SERVER, 'REQUEST_URI');
//    }
//
//    // юзаются для кеша
//    //cPages::getPath()
//    //cInput::url()->path()
//	static public function getPath() {
//        return parse_url(self::getUrl(), PHP_URL_PATH);
//    }
}
