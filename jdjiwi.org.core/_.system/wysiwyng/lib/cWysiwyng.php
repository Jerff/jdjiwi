<?php

\Jdjiwi\Loader::library('wysiwyng:tinymce/cWysiwyngTinymce');
\Jdjiwi\Loader::library('wysiwyng:ckeditor/cWysiwyngKCKeditor');

class cWysiwyng {

    static private function driver() {
        if (empty(self::$instance)) {
            switch (\Jdjiwi\Config::get('wysiwyng.driver')) {
                case 'KCKeditor':
                    self::$instance = new cWysiwyngKCKeditor();
                    break;

                case 'tinymce':
                    self::$instance = new cWysiwyngTinymce();
                    break;

                default:
                    throw new \Jdjiwi\Exception('нет установлен драйвер визуального редактора');
                    exit;
            }
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments) {
        return self::driver()->$name(...$arguments);
    }

}

