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
                self::mkdir($path);
            }
            return true;
        } catch (Exception $e) {
            Log::addError($e->getMessage());
            return false;
        }
    }

}
