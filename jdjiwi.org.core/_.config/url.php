<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'item' => \Jdjiwi\Pages\Router::start() . '/',
    'app' => \Jdjiwi\Pages\Router::get('application') . '/',
    'ajax' => \Jdjiwi\Pages\Router::get('ajax') . '/',
    'compile' => array(
        'jsCss' => \Jdjiwi\Pages\Router::get('compileJsCss') . '/'
    ),
    'admin' => \Jdjiwi\Pages\Router::get('admin') . '/',
);
