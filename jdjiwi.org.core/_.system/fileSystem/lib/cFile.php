<?php

use Jdjiwi\FileSystem\Exception;

class cFile {
    /* === копирование файлов === */

    static function copy($file, $newFile) {
        try {
            $folder = dirname($newFile);
            cFileSystem::mkdir($folder);
            cFile::isWritable($file);
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
            cFileSystem::chmod($name);
            return $name;
        } catch (Exception $e) {
            $e->addErrorLog('Невозможно скопировать файл');
        }
        return false;
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
