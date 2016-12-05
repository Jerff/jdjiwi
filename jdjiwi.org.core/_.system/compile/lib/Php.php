<?php

namespace Jdjiwi\Compile;

use Jdjiwi\Crypt,
    Jdjiwi\Config,
    Jdjiwi\Loader,
    Jdjiwi\Strings,
    Jdjiwi\FileSystem,
    Jdjiwi\FileSystem\Utility;

class Php {
    /*
     *  compile sourse path
     */

    static private function path() {
        return cSoursePath . Config::get('compile.path');
    }

    static public function load($type, $file) {
        if (Config::get('compile.is') < 2) {
            return $file;
        }
        $hash = Crypt::hash(Loader::getIndex(), $type, $file);
        $compile = self::path() . $type . '/' . substr($hash, 0, 1) . '/' . substr($hash, 1, 2) . '/' . $hash . '.php';
        if (file_exists($compile)) {
            return $compile;
        }
        Loader::initLoad();
        require_once ($file);
        Utility::putContent($compile, self::compile(Loader::getLoadFile()));
    }

    /*
     * update
     */

    static public function createrLoader() {
        Utility::putContent(
                self::path() . Compile\Config::loaderPhp(), self::compile(Loader::getLoadFile())
        );
    }

    static public function update() {
        FileSystem::rmdir(self::path());
    }

    static public function compile($arFiles) {
        $compile = $loader = $history = $content = '';
        foreach ($arFiles as $file) {
            $code = "<?php\n#include {$file}\n?>"
                    . self::parse($file)
                    . "?><?php\n#end {$file}\n?>";
            $arg = explode('::', $file);
            switch ($arg[0]) {
                case 'Config':
                case 'Modul':
                    $compile .= "<?php \Jdjiwi\Loader\Compile::compile('{$file}', function() { ?>{$code}<?php }); ?>";
                    break;

                case 'Loader':
                    switch ($file) {
                        case '\Jdjiwi\Loader::loader/compile/Compile':
                            $history .= "<?php \Jdjiwi\Loader::setHistory('{$arg[1]}'); ?>";
                            $loader .= $code;
                            break;

                        default:
                            $history .= "<?php \Jdjiwi\Loader::setHistory('{$arg[1]}'); ?>";
                            $content .= $code;
                            break;
                    }
                    break;

                default:
                    break;
            }
        }
        $content .= "<?php \Jdjiwi\Modul::load('loader'); ?>";
        $content = preg_replace('#\?>\s*<\?php#S', ' ', $loader . $compile . $history . $content);
        $content = str_replace("\r", '', $content);
        return $content;
    }

    static private $itemFile = false;

    static private function file($file) {
        self::$itemFile = $file;
        $content = Strings::convertEncoding(php_strip_whitespace($file));
        $content = trim(preg_replace_callback("#(\".*?\")|('.*?')|(\{.*?\})|((require|require_once|include|include_once)\('(.*?)'\);)#sS", array(&$this, 'includeFile'), $content));
        if (substr($content, -2) === '?>') {
            $content = substr($content, 0, -2);
        }
        return $content;
    }

    static private function includeFile($m) {
        if (!isset($m[6]))
            return $m[0];
        //realpath
        return self::file($m[6]);
    }

    private function parse($file) {
        $arg = explode('::', $file);
        switch ($arg[0]) {
            case 'Loader':
            case 'Config':
            case 'Modul':
                return self::file($arg[1] . '.php');

            default:
                break;
        }
        return self::file($file);
    }

}
