<?php

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
                throw new cFileException('файл не скопирован', array($file, $name));
            }
            cFileSystem::chmod($name);
            return $name;
        } catch (cFileException $e) {
            $e->errorLog('Невозможно скопировать файл');
        }
        return false;
    }

    // проверка на достпуность записи
    static public function isWritable($file) {
        if (file_exists($file)) {
            if (!is_writable($file)) {
                throw new cFileException('Невозможна запись в файл', $file);
            }
        } else {
            if (!is_writable(dirname($file))) {
                throw new cFileException('Невозможно создать файл в папке', dirname($file));
            }
        }
        return true;
    }

}

?>