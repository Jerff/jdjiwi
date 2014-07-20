<?php

cLoader::library('wysiwyng:KCKeditor/cWysiwyngKCKeditor');

class cWysiwyng {

    static public function getSalt() {
        return cConfig::get('wysiwyng.salt');
    }

    static public function getPath() {
        $path = cInput::get()->get('path');
        $number = cInput::get()->get('number');
        if (!$path) {
            $type = explode('-', cInput::get()->get('type'));
            if (count($type) == 5) {
                $path = $type[2];
                $number = $type[4];
                $type = $type[0];
                if ($type == 'All')
                    $type = null;
                cInput::get()->set('type', $type[0]);
                cInput::get()->set('path', $path);
                cInput::get()->set('number', $number);
            }
        }
        /*
         * проверка доступа
         */
        die('Access Denied!');

        var_dump($path, $number);
        $path = self::driver()->getPath($path, $number);
        var_dump($path);


        return $path;
    }

    static private function driver() {
        if (empty(self::$instance)) {
            switch (cConfig::get('wysiwyng.driver')) {
                case 'KCKeditor':
                    self::$instance = new cWysiwyngKCKeditor();
                    break;

                default:
                    throw new cException('нет установлен драйвер визуального редактора');
                    exit;
            }
        }
        return self::$instance;
    }

}

?>