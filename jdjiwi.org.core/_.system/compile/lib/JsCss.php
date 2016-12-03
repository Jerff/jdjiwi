<?php

namespace Jdjiwi\Compile;

use Jdjiwi\Crypt,
    Jdjiwi\Loader,
    Jdjiwi\Str,
    Jdjiwi\Debug,
    Jdjiwi\FileSystem,
    Jdjiwi\FileSystem\Utility;

//Loader::library('vendor/meenie/javascript-packer/class.JavaScriptPacker');

class JsCss {
    /*
     * config
     */

    static public function pathWWW($type, $file) {
        return '/' . Compile\Config::pathJsCss() . '/v/' . time() . '/' . $type . '/' . Crypt::hash($file);
    }

    static public function pathCompile($type, $file) {
        return cWWWPath . Compile\Config::pathJsCss() . '/' . Crypt::hash($file) . '.' . $type;
    }

    /*
     * update
     */

    public function update() {
        FileSystem::rmdir(cWWWPath . Compile\Config::pathJsCss());
    }

    /*
     * данные
     */

    static private $value = null;

    static private function set($value) {
        self::$value = $value;
    }

    static public function get() {
        return self::$value;
    }

    /*
     * compile
     */

    static public function compile($sFile) {
        switch ($type = preg_replace('~^.+\.(css|js|map)$~', '$1', $sFile)) {
            case 'js':
                header('Content-Type: application/x-javascript');
                $sep = ';';
                break;

            case 'css':
                header('Content-Type: text/css');
                $sep = '';
                break;

            default:
                exit;
        }

        $arList = explode(';', $sFile);
        $path = '';
        foreach ($arList as $key => $value) {
            if (preg_match('~\/~', $value)) {
                $path = dirname($value);
            } else {
                if ($path) {
                    $arList[$key] = $path . '/' . $value;
                }
            }
        }

        $content = '';
        foreach ($arList as $file) {
            if (is_file(cWWWPath . $file)) {
                $sourse = Str::convertEncoding(file_get_contents(cWWWPath . $file));
                self::set(dirname($file) . '/');
                switch ($type) {
                    case 'js':
                        $sourse = preg_replace_callback("#(@\s+sourceMappingURL=)([^\s]+.map)#sS", function($m) {
                            if (isset($m[2])) {
                                return $m[1] . cCompileJsCss::get() . $m[2];
                            }
                            return $m[0];
                        }, $sourse);
                        if (Str::strrpos($file, 'min') === false and Str::strrpos($file, 'pack') === false) {
                            $sourse = new JavaScriptPacker($sourse, 'None', false, false);
                            $sourse = $sourse->pack();
                        }
                        break;

                    case 'css':
                        $sourse = preg_replace_callback("#(url\s*\([\s\"\']*)([^\)\"\'\s]+)([\s\"\']*\))#sS", function($m) {
                            if (substr($m[2], 0, 3) === '../') {
                                return $m[1] . cCompileJsCss::get() . substr($m[2], 3) . $m[3];
                            } else if (substr($m[2], 0, 1) !== '/') {
                                return $m[1] . cCompileJsCss::get() . $m[2] . $m[3];
                            }
                            return $m[0];
                        }, $sourse);
                        break;
                }
                $content .= PHP_EOL . '/* ' . $file . ' */' . PHP_EOL . $sourse . PHP_EOL . $sep . PHP_EOL;
            }
        }
        Debug::disable();
        echo $content;
        Utility::putContents(self::pathCompile($type, $sFile), $content);
    }

    /*
     * compile header list
     */

    static public function initHeader(&$arData) {
        if (!Compile::is())
            return;
        $lastKey = $lastPath = array();
        foreach ($arData as $key => list($type, $value)) {
            switch ($type) {
                case 'string':
                    $lastKey = $lastPath = array();
                    break;

                case 'js':
                case 'css':
                    $path = dirname($value);
                    if (get($lastPath, $type) === $path) {
                        $arData[$lastKey[$type]][1] .= ';' . basename($value);
                        unset($arData[$key]);
                    } else {
                        if (isset($lastKey[$type])) {
                            $arData[$lastKey[$type]][1] .= ';' . $value;
                            unset($arData[$key]);
                        } else {
                            $lastKey[$type] = $key;
//                                $mData[$lastKey[$type]][1] = Compile\file::path($type) . $mData[$lastKey[$type]][1];
                        }
                        $lastPath[$type] = $path;
                    }
                    break;

                case 'jsSousre':
                    unset($lastKey['js'], $lastPath['js']);
                    break;

                case 'cssSousre':
                    unset($lastKey['css'], $lastPath['css']);
                    break;

                default:
                    break;
            }
        }
        foreach ($arData as $key => list($type, $value)) {
            switch ($type) {
                case 'js':
                case 'css':
                    $arData[$key][1] = self::pathWWW($type, $value) . $value;
                    break;
                default:
                    break;
            }
        }
    }

}
