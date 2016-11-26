<?php

namespace Jdjiwi\FileSystem;

class Folder {

    static public function getFileList($folder) {
        $arResult = array();
        if (!is_dir($folder)) {
            return $arResult;
        }
        foreach (scandir($folder) as $file) {
            if (is_file($folder . $file) and $file{0} !== '.') {
                $arResult[] = $folder . $file;
            }
        }
        return $arResult;
    }

    static public function getList($folder) {
        $arResult = array();
        if (!is_dir($folder)) {
            return $arResult;
        }
        foreach (scandir($folder) as $file) {
            if (is_dir($folder . $file) and $file{0} !== '.') {
                $arResult[] = $folder . $file . '/';
            }
        }
        return $arResult;
    }

}
