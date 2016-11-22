<?php

use Jdjiwi\FileSystem\Exception;

class cFileUpload {

    // upload file
    static function upload($folder, $upload) {
        try {
            $name = $file = cFileSystem::toFileName($upload['name']);
            $prefix = rand(0, 50) . '/' . rand(0, 50) . '/';
            $folder .= $prefix;
            cFileSystem::mkdir($folder);
            cFile::isWritable($file);
            while (file_exists($folder . $name)) {
                if (strpos($file, '.')) {
                    $name = preg_replace('~(.*)\.([^.]*)$~S', '$1.' . rand(0, 9999) . '.$2', $file);
                } else {
                    $name = $file . rand(0, 9999);
                }
            }
            if (!move_uploaded_file($upload['tmp_name'], $folder . $name)) {
                throw new Exception('файл не перемещен', array($file, $name));
            }
            cFileSystem::chmod($folder . $name);
            return $prefix . $name;
        } catch (Exception $e) {
            $e->errorLog('Невозможно сохранить загруженый файл');
        }
        return false;
    }

}
