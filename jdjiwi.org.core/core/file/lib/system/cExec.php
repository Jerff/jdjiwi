<?php

class cFileSystem {

    // проверка папки
    static public function is($folder) {
        return is_dir($folder);
    }

    // имя каталога
    static public function name($folder) {
        return dirname($folder);
    }

    // сменить права
    static public function chmod($folder, $mode = cDirMode) {
        if (!chmod($folder, $mode)) {
            throw new cFileException('права файла не изменены', array($folder, $mode));
        }
    }

    // создание папки
    static public function create($path, $mode = cDirMode) {
        if (self::is($path)) {
            return true;
        }
        if (!$is = mkdir($path, $mode, true)) {
            throw new cFileException('Невозможно создать папку', $path);
        }
        self::chmod($path, $mode);
    }

}

?>