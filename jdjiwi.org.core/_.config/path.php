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
//define('cConfigPath', '_.config/');

/*
 * Системная папка
 */
//define('cDataPath', cSoursePath . '.data/');

/* app */
//define('cAppPathTheme', cSoursePath . 'themes/core/');
//define('cAppPathAjax', cAppPathTheme . 'ajax/');
//define('cAppPathController', cAppPathTheme . 'controller/');
//define('cAppPathTemplates', cAppPathTheme . 'templates/');
//define('cAppPathPage', cAppPathTheme . 'templates/');

/* components */
//define('cComponentsPath', cSoursePath . 'components/');
?>