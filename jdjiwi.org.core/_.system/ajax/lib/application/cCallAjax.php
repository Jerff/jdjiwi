<?php

class cCallAjax {

    static public function start() {
        cAjax::start();
        $file = str_replace(cAjaxUrl, '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $file = preg_replace('~(([\-a-z\.\/]*)\/).*~is', '$2', $file);
        $file = cConfig::get('path.app.ajax') . str_replace(array('..', '.'), '', $file) . '.php';
        if (!is_file($file)) {
            throw new cException('контроллер не существует', $file);
        }
        return require(cCompile::path('ajax', $file));
    }

}

?>