<?php

cLoader::library('file:exception/cFileException');
cLoader::library('file:system/cExec');
cLoader::library('core:string/cConvert');

class cFileSystem {

    static private function isExec() {
        static $is = null;
        if ($is !== null) {
            return $is;
        }
        return $is = !in_array('exec', explode(',', ini_get('disable_functions')));
    }

    // сменить права
    static public function chmod($folder, $mode = cDirMode) {
        if (!chmod($folder, $mode)) {
            throw new cFileException('права файла не изменены', array($folder, $mode));
        }
    }

    static public function unlink($file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    static public function toFileName($str) {
        $str = preg_replace('~([^a-z0-9\_\-\=\+\.])~S', '_', cConvert::translate($str));
        return preg_replace('~(_{2,})~S', '_', $str);
    }

}

?>