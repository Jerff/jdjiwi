<?php

use \Jdjiwi\Exception;

\Jdjiwi\Loader::library('pages:cUrlAdmin');
\Jdjiwi\Loader::library('trait:cTraitStaticRegistry');

class cUrl {

    use cTraitStaticRegistry;

    static public function admin() {
        return self::register('cUrlAdmin');
    }

    static public function reform($uri, &$param) {
        if (empty($param))
            return $uri;
        foreach ($param as $k => $v) {
            $uri = str_replace('(' . ($k + 1) . ')', $v, $uri);
        }
        return $uri;
    }

    //cUrl::get
    static public function get() {
        try {
            $param = func_get_args();
            $conf = cPages::getPageConfig(array_shift($param));
            if ($conf and $conf->isNoPage()) {
                throw new Exception('нет такой страницы', func_get_args());
            }
            return cPages::base()->{$conf->base} . self::reform($conf->uri, $param);
        } catch (Exception $e) {
            $e->addErrorLog();
        }
        return false;
    }

    //cUrl::param
    static public function param($param) {
        try {
            $conf = cPages::getPageConfig(array_shift($param));
            if ($conf and $conf->isNoPage()) {
                throw new Exception('нет такой страницы', func_get_args());
            }
            return cPages::base()->{$conf->base} . self::reform($conf->uri, $param);
        } catch (Exception $e) {
            $e->addErrorLog();
        }
        return false;
    }

    //cUrl::lang
    static public function lang() {
        try {
            $param = func_get_args();
            $lang = array_shift($param);
            $conf = cPages::getPageConfig(array_shift($param));
            if ($conf and $conf->isNoPage()) {
                throw new Exception('нет такой страницы', func_get_args());
            }
            return cPages::base()->{$conf->base} . self::reform($conf->uri, $param);
        } catch (Exception $e) {
            $e->addErrorLog();
        }
        return false;
    }

    //cUrl::uri
    static public function uri() {
        try {
            $param = func_get_args();
            $uri = cPages::getPageConfig(array_shift($param), 'u');
            if (empty($uri)) {
                throw new Exception('нет такой страницы', func_get_args());
            }
            return self::reform($uri, $param);
        } catch (Exception $e) {
            $e->addErrorLog();
        }
        return false;
    }

}

