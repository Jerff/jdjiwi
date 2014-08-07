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
     * app
     */
    'app.ajax' => cConfig::get('host.app.theme') . 'ajax/',
    'app.controller' => cConfig::get('host.app.theme') . 'controller/',
    'app.form' => cConfig::get('host.app.theme') . 'form/',
    'app.templates' => cConfig::get('host.app.theme') . 'templates/',
    /*
     * components 
     */
    'components' => cSoursePath . 'components/',
);
