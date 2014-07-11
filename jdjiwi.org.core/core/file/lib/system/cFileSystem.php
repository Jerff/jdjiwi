<?php

cLoader::config('file');
cLoader::library('file:exception/cFileException');
cLoader::library('file:system/cExec');
cLoader::library('core:string/cConvert');

class cFileSystem {

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

    // создание папки
    static public function mkdir($path, $mode = cDirMode) {
        if (is_dir($path)) {
            return true;
        }
        if (!$is = mkdir($path, $mode, true)) {
            throw new cFileException('Невозможно создать папку', $path);
        }
        self::chmod($path, $mode);
    }

    static public function rmdir($folder, $del = false) {
        if (!is_dir($folder)) {
            return;
        }
        if (cExec::is()) {
            cExec::run('rm -rf ' . $folder);
            if (!$del) {
                self::mkdir($folder);
            }
        } else {
            foreach (scandir($folder) as $file) {
                if (is_dir($folder . $file) and $file{0} !== '.') {
                    self::rmdir($folder . $file . '/');
                    rmdir($folder . $file . '/');
                } else {
                    if (is_file($folder . $file) and $file{0} !== '.') {
                        unlink($folder . $file);
                    }
                }
            }
            sleep(1);
            if ($del) {
                rmdir($folder);
            }
        }
    }

    static public function toFileName($str) {
        $str = preg_replace('~([^a-z0-9\_\-\=\+\.])~S', '_', cConvert::translate($str));
        return preg_replace('~(_{2,})~S', '_', $str);
    }

}

?>