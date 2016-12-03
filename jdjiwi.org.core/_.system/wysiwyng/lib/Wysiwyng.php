<?php

namespace Jdjiwi;

use Jdjiwi\Exception;

//Loader::library('wysiwyng:tinymce/cWysiwyngTinymce');
//Loader::library('wysiwyng:ckeditor/cWysiwyngKCKeditor');

class cWysiwyng {

    static private function driver() {
        if (empty(self::$instance)) {
            switch (Config::get('wysiwyng.driver')) {
                case 'KCKeditor':
                    self::$instance = new Wysiwyng\KCKeditor();
                    break;

                case 'tinymce':
                    self::$instance = new Wysiwyng\Tinymce();
                    break;

                default:
                    throw new Exception('нет установлен драйвер визуального редактора');
                    exit;
            }
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments) {
        return self::driver()->$name(...$arguments);
    }

}
