<?php

namespace Jdjiwi\FileSystem;

use Jdjiwi\Log;

class Utility {

    static public function putContent($path, $content, $flags = 0, $context = null) {
        if (self::checkPath($path)) {
            file_put_contents($filename, $data, $flags, $context);
        }
    }

    static public function getContent($path) {

    }

    static public function checkPath($path) {
        try {
            $path = dirname($path);
            if (!is_dir($path)) {
            }
            return true;
        } catch (Exception $ex) {
            Log::addError($message);
            return false;
        }
    }

}
