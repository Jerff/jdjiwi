<?php

return array(
    /*
     * Системная папка
     */
    'data' => cSoursePath . '.data/',
    /*
     * app 
     */
    'app.ajax' => cConfig::get('host.app.theme') . 'ajax/',
    'app.controller' => cConfig::get('host.app.theme') . 'controller/',
    'app.templates' => cConfig::get('host.app.theme') . 'templates/',
    /*
     * components 
     */
    'components' => cSoursePath . 'components/',
);
