<?php

return array(
    /*
     * Системная папка
     */
    'data' => cSoursePath . '.data/',
    /*
     * compile
     */
    'compile' => cWWWPath . 'core-compile/',
    /*
     * file
     */
    'file' => cWWWPath .\Jdjiwi\Config::get('file.path'),
    'file.tmp' => cWWWPath .\Jdjiwi\Config::get('file.path.tmp'),
    /*
     * app
     */
    'app.ajax' => \Jdjiwi\Config::get('host.app.theme') . 'ajax/',
    'app.controller' => \Jdjiwi\Config::get('host.app.theme') . 'controller/',
    'app.form' => \Jdjiwi\Config::get('host.app.theme') . 'form/',
    'app.templates' => \Jdjiwi\Config::get('host.app.theme') . 'templates/',
    /*
     * components
     */
    'components' => cSoursePath . 'components/',
);
