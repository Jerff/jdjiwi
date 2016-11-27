<?php

namespace Jdjiwi\Pages;

use Jdjiwi\Input\Get,
    Jdjiwi\Config,
    Jdjiwi\Loader,
    Jdjiwi\Ajax,
    Jdjiwi\Exception,
    Jdjiwi\Str,
    Jdjiwi\Log;

class Router {

    static private $arSection = null;

    static public function get($name) {
        return isset(self::$arSection[$name]) ? self::$arSection[$name] : null;
    }

    static public function start() {
        self::$arSection = Config::get('router.list');
        try {
            if (defined('cApplication')) {
                if (isset(self::$arSection[cApplication])) {
                    return self::$arSection[cApplication];
                } else {
                    throw new Exception('не найден раздел сайта', cApplication);
                    exit;
                }
            }
            $mSearch = array();
            $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . Config::get('host.uri');
            foreach (self::$arSection as $key => $value) {
                if (strpos($url, $value) !== false) {
                    $mSearch[Str::strlen($value)] = $key;
                }
            }
            if (empty($mSearch)) {
                throw new Exception('неправильный раздел сайта');
            }
            krsort($mSearch);
            define('cApplication', each($mSearch)['value']);
        } catch (Exception $e) {
            Log::addError($e);
            if (!defined('cApplication')) {
                define('cApplication', 'application');
            }
        }
        return self::$arSection[cApplication];
    }

    /* Application */

    static public function application(&$arPages) {
        Pages::set($arPages);
        if (cApplication !== 'application') {
            return;
        }

        $url = parse_url('http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], strlen(Config::get('url.itemUri'))), PHP_URL_PATH);
        $url = urldecode($url);

        $page = '/404/';
        $param = null;
        if (isset($arPages2[cApplication][$url])) {
            $page = $arPages2[cApplication][$url];
        } else if (isset($mPr[cApplication])) {
            unset($arPages2);
            while (list($k, $v) = each($mPr[cApplication])) {
                foreach ($v as $p) {
                    if (preg_match($p, $url, $tmp)) {
                        $page = $k;
                        $param = $tmp;
                        break;
                    }
                }
                if (!is_null($param)) {
                    break;
                }
            }
        }
        if ($page === '/404/') {
            header("HTTP/1.0 404 Not Found");
        }
        if ($param) {
            array_shift($param);
        }
        Param::setMain($page);
        Param::set($param);
    }

    /* Admin */

    static public function admin(&$arPages) {
        if (cApplication !== 'admin') {
            return;
        }
        Pages::set($arPages);

//        if (!cAdmin::user()->is()) {
//            self::setMain('/admin/enter/');
//            return;
//        }

        if (Get::is('url')) {
            $url = Get::get('url');
        } else if (!Ajax::is()) {
            Pages::setMain('/admin/index/');
            return;
        } else {

            $url = Ajax::getUrl();
            preg_match('~' . preg_quote(cAdminUrl) . '([^#]*)\#?(\&?.*)~', $url, $tmp);
            $url = empty($tmp[1]) ? '/' : $tmp[1];
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== Config::get('host.url')) {
                self::setMain('/admin/index/');
                return;
            }
        }

        if (!empty($tmp[2])) {
            foreach (explode('&', $tmp[2]) as $v)
                if ($v) {
                    $v = explode('=', $v);
                    if (isset($v[1])) {
                        Get::set($v[0], $v[1]);
                    } else {
                        Get::set($v[0], 1);
                    }
                }
        }

        $page = false;
        $param = null;
        while (list($k, $v) = each($arPages)) {
            if (isset($v['b']))
                continue;
            if (isset($v['preg'])) {
                foreach ($v['preg'] as $p) {
                    if (preg_match($p, $url, $preg)) {
                        $page = $k;
                        $param = $preg;
                        break;
                    }
                }
                if (!is_null($param))
                    break;
            }
            if (isset($v['u']) and $v['u'] === $url) {
                $page = $k;
                break;
            }
        }
        if (!$page) {
            Ajax::get()->alert('Ничего не найдено!');
            exit;
        }

        if ($param) {
            array_shift($param);
        }
        Param::setMain($page);
        Param::set($param);
    }

}
