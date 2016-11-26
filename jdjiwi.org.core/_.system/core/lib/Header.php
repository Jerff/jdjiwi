<?php

namespace Jdjiwi;

use Jdjiwi\Compile\JsCss;

Loader::library('core:header/Seo');
Modul::load('compile');

class Header {

    private static $arData = array();

    private static function addType($type, $value) {
        self::$arData[] = [$type, $value];
    }

    static public function addString($string) {
        self::addType('string', $string);
    }

    static public function addSeporator() {
        self::addString('');
    }

    static public function addJs($js) {
        self::addType('js', $js);
    }

    static public function addJsSousre($js) {
        self::addType('jsSousre', $js);
    }

    static public function addCss($css) {
        self::addType('css', $css);
    }

    static public function addCssSousre($css) {
        self::addType('cssSousre', $css);
    }

    static public function addMeta() {
        return self::addType('meta', func_get_args());
    }

    /* view s */

    static public function getHead($isBase = true) {
        return Buffer::add(function() use ($isBase) {
                    $head = '';
                    if ($isBase) {
                        $head .= '
        <base href="' . Config::get('url.app') . '/"/>';
                    }
                    $head .= '
        <meta content="text/html; charset=' . Config::get('i18n.charset') . '" http-equiv="Content-Type"/>';

                    JsCss::initHeader(self::$arData);
                    foreach (self::$arData as $key => list($type, $value)) {
                        switch ($type) {
                            case 'string':
                                $head .= $value;
                                break;

                            case 'js':
                            case 'jsSousre':
                                $head .= '
        <script type="text/javascript" src="' . $value . '"></script>';
                                break;

                            case 'css':
                            case 'cssSousre':
                                $head .= '
        <link href="' . $value . '" rel="stylesheet" type="text/css" />';
                                break;

                            case 'meta':
                                $head .= "
        <meta ";
                                foreach ($value as list($k, $v)) {
                                    $head .= '"' . $k . '"="' . $v . '" ';
                                }
                                $head .= '/>';
                                break;
                        }
                    }
                    self::$arData = null;
                    return $head;
                });
    }

}
