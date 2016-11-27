<?php

namespace Jdjiwi\FileSystem;

use Jdjiwi\Log,
    Jdjiwi\FileSystem\Exception;

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
            $path = dirname($path);
            if (!is_dir($path)) {
                if (is_file($path)) {
                    throw new Exception('на месте папки только файл', $path);
                }
                FileSystem::mkdir($path);
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
    static public function isWritable($file) {
        if (file_exists($file)) {
            if (!is_writable($file)) {
                throw new Exception('Невозможна запись в файл', $file);
            }
        } else {
            if (!is_writable(dirname($file))) {
                throw new Exception('Невозможно создать файл в папке', dirname($file));
            }
        }
        return true;
    }

}
