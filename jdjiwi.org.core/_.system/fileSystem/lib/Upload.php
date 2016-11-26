<?php

namespace Jdjiwi\FileSystem;

class Upload {

    // upload file
    static function load($folder, $upload) {
        try {
            $name = $file = FileSystem::toFileName($upload['name']);
            $prefix = rand(0, 50) . '/' . rand(0, 50) . '/';
            $folder .= $prefix;
            FileSystem::mkdir($folder);
            File::isWritable($file);
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
            FileSystem::chmod($folder . $name);
            return $prefix . $name;
        } catch (Exception $e) {
            $e->addErrorLog('Невозможно сохранить загруженый файл');
        }
        return false;
    }

}
