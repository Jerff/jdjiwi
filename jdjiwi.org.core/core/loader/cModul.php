<?php

cLoader::library('cLoaderException');

class cModul {

    static private $mLoad = array();

    static public function load($modul) {
        if (empty($modul) or ! is_string($modul)) {
            throw new cModulException("Не указано имя модуля");
        }
        if (preg_match("#[^a-z0-9:._]#iS", $modul)) {
            throw new cModulException(sprintf("Название модуля '%s' не корректно", $modul));
        }
        $modul = str_replace(':', '/', $modul);
        if (isset(self::$mLoad[$modul])) {
            return self::$mLoad[$modul];
        }
        if (!is_file($modul . '/include.php')) {
            throw new cModulException("Модуль не найден");
        }
//        set_include_path(get_include_path() .
//                PATH_SEPARATOR . $modul . '/' .
//                PATH_SEPARATOR . $modul . '/lib/'
//        );
        require_once($modul . '/include.php');
        return self::$mLoad[$modul] = true;
    }

}

?>