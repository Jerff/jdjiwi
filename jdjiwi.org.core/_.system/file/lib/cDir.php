<?php

class cDir {

    static public function getFiles($folder) {
        $result = array();
        if (!is_dir($folder)) {
            return $result;
        }
        foreach (scandir($folder) as $file) {
            if (is_file($folder . $file) and $file{0} !== '.') {
                $result[] = $folder . $file;
            }
        }
        return $result;
    }

    static public function getFolders($folder) {
        $result = array();
        if (!is_dir($folder)) {
            return $result;
        }
        foreach (scandir($folder) as $file) {
            if (is_dir($folder . $file) and $file{0} !== '.') {
                $result[] = $folder . $file . '/';
            }
        }
        return $result;
    }

}

