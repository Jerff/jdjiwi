<?php

class cAjaxCall {

    static protected function start() {
        cApplication::authorization();
        ini_set('html_errors', 'Off');

        cAjax::start();
        $file = str_replace(cAjaxUrl, '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $file = preg_replace('~(([\-a-z\.\/]*)\/).*~is', '$2', $file);
        $file = \Jdjiwi\Config::get('path.app.ajax') . str_replace(array('..', '.'), '', $file) . '.php';
        if (!is_file($file)) {
            throw new \Jdjiwi\Exception('контроллер не существует', $file);
        }
        return cCompile::php()->load('ajax', $file);
    }

}

