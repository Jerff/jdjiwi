<?php

namespace Jdjiwi\Ajax;

use Jdjiwi\Config,
    Jdjiwi\Exception,
    Jdjiwi\Application,
    Jdjiwi\Compile\Php;

class Call {

    static protected function start() {
        Application::authorization();
        ini_set('html_errors', 'Off');

        Ajax::start();
        $file = str_replace(cAjaxUrl, '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $file = preg_replace('~(([\-a-z\.\/]*)\/).*~is', '$2', $file);
        $file = Config::get('path.app.ajax') . str_replace(array('..', '.'), '', $file) . '.php';
        if (!is_file($file)) {
            throw new Exception('контроллер не существует', $file);
        }
        return Php::load('ajax', $file);
    }

}
