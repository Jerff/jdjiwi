<?php

return array(
    /*
     * Системная папка
     */
    'data' => cSoursePath . '.data/',
    /*
     * app 
     */
    'app.controller' => cConfig::get('host.app.theme') . 'controller/',
    'app.templates' => cConfig::get('host.app.theme') . 'templates/',
    /*
     * components 
     */
    'components' => cSoursePath . 'components/',
);
?>