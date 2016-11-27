<?php

namespace Jdjiwi;

use Jdjiwi\FileSystem\Exception,
    Jdjiwi\Str\Convert,
    Jdjiwi\Config;

Loader::library('fileSystem:Access');

class FileSystem {

    // сменить права
    static public function chmod($path, $mode = null) {
        Access::path($path);
        if (is_null($mode)) {
            $mode = Config::get('file.mode.file');
        }
        if (!chmod($path, $mode)) {
            throw new Exception('права файла не изменены', array($path, $mode));
        }
    }

    static public function unlink($file) {
        Access::path($file);
        if (is_file($file)) {
            unlink($file);
        }
    }

    // создание папки
    static public function mkdir($folder, $mode = null) {
        Access::path($folder);
        if (is_dir($folder)) {
            return true;
        }
        if (is_null($mode)) {
            $mode = Config::get('file.mode.dir');
        }
        if (!$is = mkdir($folder, $mode, true)) {
            throw new Exception('Невозможно создать папку', $folder);
        }
        self::chmod($folder, $mode);
    }

    static private function _rmdir($folder) {
        foreach (scandir($folder) as $file) {
            if (is_dir($folder . $file) and $file{0} !== '.') {
                self::_rmdir($folder . $file . '/');
                rmdir($folder . $file . '/');
            } else {
                if (is_file($folder . $file) and $file{0} !== '.') {
                    unlink($folder . $file);
                }
            }
        }
    }

    static public function rmdir($folder, $del = false) {
        Access::path($folder);
        if (!is_dir($folder)) {
            return;
        }
        if (Shell::isOn()) {
            Shell::exec('rm -rf ' . $folder);
            if (!$del) {
                self::mkdir($folder);
            }
        } else {
            self::_rmdir($folder);
            sleep(1);
            if ($del) {
                rmdir($folder);
            }
        }
    }

    static function copy($file, $newFile) {
        try {
            $folder = dirname($newFile);
            FileSystem::mkdir($folder);
            Utility::isWritable($file);
            $name = $newFile;
            while (file_exists($name)) {
                if (strpos($file, '.')) {
                    $name = preg_replace('`(.*)\.([^.]*)$`', '$1.' . rand(0, 9999) . '.$2', $newFile);
                } else {
                    $name = $newFile . rand(0, 9999);
                }
            }
            if (copy($file, $name)) {
                throw new Exception('файл не скопирован', array($file, $name));
            }
            self::chmod($name);
            return $name;
        } catch (Exception $e) {
            $e->addErrorLog('Невозможно скопировать файл');
        }
        return false;
    }

}
