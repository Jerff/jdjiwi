<?php

//namespace Jdjiwi\FileSystem;

use Jdjiwi\Loader,
    Jdjiwi\Str,
    Jdjiwi\Compile,
    Jdjiwi\FileSystem\Utility;

Loader::library('packer.php/class.JavaScriptPacker');

class File {

    static private $arInclude = null;

    static private function reset() {
        self::$arInclude = array();
    }

    static private function pack($list, $file, $js) {
        if (isset(self::$arInclude[$file]))
            return '';
        foreach ($list as $dir) {
            if (is_file($dir . $file)) {
                $sourse = Str::convertEncoding(file_get_contents($dir . $file));
                break;
            }
        }
        if (!isset($sourse))
            return '';

        $include = '';
        preg_match_all('~//include\((.+)\);~', $sourse, $search);
        if ($search[1]) {
            foreach ($search[1] as $v)
                if (!isset(self::$arInclude[$v])) {
                    $include .= self::pack($list, $v, $js);
                }
        }
        self::$arInclude[$file] = 1;

        if (Str::strrpos($file, 'min') === false and Str::strrpos($file, 'pack') === false and $js) {
            $sourse = new JavaScriptPacker($sourse, 'None', false, false);
            $sourse = $sourse->pack();
        }
        return $include . PHP_EOL . $sourse;
    }

    static public function compile($name, $js = true) {
        $sep = $js ? ';' : '';
        $sourse = '';
        list($name, $list) = $name;
        self::reset();
        foreach ($list as $dir) {
            $prefix = preg_replace('~^.+(\..+)$~i', '$1', $name);
            foreach (Folder::getFileList($dir) as $file) {
                if ($name != $file and Str::strrpos($file, $prefix) !== false) {
                    $sourse .= self::pack($list, $file, $js);
                    $sourse .= "\n{$sep}\n";
                }
            }
        }

        if ($sourse) {
            Utility::putContent(Compile\Config::soursePath() . $name, $sourse);
        }
    }

}
