<?php

cLoader::library('file:exception/cFileException');
cLoader::library('file:system/cExec');
cLoader::library('file:system/cFileAccess');
cLoader::library('core:string/cConvert');

class cFileSystem {

    // сменить права
    static public function chmod($path, $mode = null) {
        cFileAccess::path($path);
        if (is_null($mode)) {
            $mode = cFileMode;
        }
        if (!chmod($path, $mode)) {
            throw new cFileException('права файла не изменены', array($path, $mode));
        }
    }

    static public function unlink($file) {
        cFileAccess::path($file);
        if (is_file($file)) {
            unlink($file);
        }
    }

    // создание папки
    static public function mkdir($folder, $mode = null) {
        cFileAccess::path($folder);
        if (is_dir($folder)) {
            return true;
        }
        if (is_null($mode)) {
            $mode = cConfig::get('file.mode.dir');
        }
        if (!$is = mkdir($folder, $mode, true)) {
            throw new cFileException('Невозможно создать папку', $folder);
        }
        self::chmod($folder, $mode);
    }

    static public function rmdir($folder, $del = false) {
        cFileAccess::path($folder);
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
