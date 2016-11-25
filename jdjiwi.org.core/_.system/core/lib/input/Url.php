<?php

namespace Jdjiwi\Input;

//pre(Url::fullPath());
//pre(Url::uri());
//exit;

class Url {

    static private $arData = array();

    static private function init() {
        if (empty(self::$arData)) {
            self::$arData = parse_url(self::fullPath());
            parse_str(get(self::$arData, 'query'), self::$arData['query']);
        }
    }

    static public function setParam($k, $v) {
        self::init();
        self::$arData[$k] = $v;
    }

    static public function getParam($k) {
        self::init();
        return get(self::$arData, $k);
    }

    static public function setQuery($k, $v) {
        self::init();
        self::$arData['query'][$k] = $v;
    }

    static public function getQuery($k) {
        self::init();
        return get2(self::$arData, 'query', $k);
    }

    static public function fullPath() {
//        return 'http://username:password@hostname:9090/path?arg=value&ffj=5#anchor';
//        return 'http://core.jdjiwi.ru/fffefe/fe?jdjd=ff&ffkgk=333kff';
        return (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    static public function host() {
        return 'http://' . $_SERVER['HTTP_HOST'];
    }

    static public function uri() {
        self::init();
        return get($_SERVER, 'REQUEST_URI');
    }

    // юзаются для кеша
    static public function getPage($arAdd = false, $arRemove = false) {
        self::init();
        $arQuery = empty(self::$arData['query']) ? array() : self::$arData['query'];
        if ($arAdd) {
            if (is_string($arAdd)) {
                parse_str($arAdd, $arAdd);
            }
            foreach ($arAdd as $key => $value) {
                $arQuery[$key] = $value;
            }
        }
        if ($arRemove) {
            foreach ((array) $arRemove as $key) {
                unset($arQuery[$key]);
            }
        }
        $url = "";
        if (!empty(self::$arData['host'])) {
            $url .= self::$arData['scheme'] . "://" . self::$arData['host'];
            if ((self::$arData['scheme'] == "http" && self::$arData['port'] != 80) || (self::$arData['scheme'] == "https" && self::$arData['port'] != 443)) {
                $url .= ":" . self::$arData['port'];
            }
        }
        if (!empty($arQuery)) {
            $url .= '?' . http_build_query($arQuery);
        }
        return $url;
    }

}
