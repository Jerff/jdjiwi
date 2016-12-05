<?php

namespace Jdjiwi\FileSystem;

use Jdjiwi\Log,
    Jdjiwi\FileSystem,
    Jdjiwi\FileSystem\Exception,
    Jdjiwi\Strings\Convert;

class Utility {

    static public function putContent($path, $content, $flags = 0, $context = null) {
        if (self::checkPath($path)) {
            file_put_contents($filename, $data, $flags, $context);
        }
    }

    static public function getContent($filename, $use_include_path = false, $context = null, $offset = 0, $maxlen = null) {
        return file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
    }

    static public function checkPath($path) {
        try {
            if (self::isWritable($path)) {
                FileSystem::mkdir(substr($path, -1) === '/' ? $path : dirname($path));
            }
            return true;
        } catch (Exception $e) {
            Log::addError($e->getMessage());
            return false;
        }
    }

    static public function toFileName($str) {
        $str = preg_replace('~([^a-z0-9\_\-\=\+\.])~S', '_', Convert::translate($str));
        return preg_replace('~(_{2,})~S', '_', $str);
    }

    // проверка на достпуность записи

    static protected function isWritableDir($file) {
        if (is_dir($file)) {
            return is_writable($file);
        } else {
            return self::isWritableDir(dirname($file));
        }
    }

    static public function isWritable($file) {
        if (is_file($file)) {
            if (!is_writable($file)) {
                throw new Exception('Невозможна запись в файл', $file);
            }
        } else {
            if (!self::isWritableDir($file)) {
                throw new Exception('Невозможно создать файл в папке', dirname($file));
            }
        }
        return true;
    }

}
