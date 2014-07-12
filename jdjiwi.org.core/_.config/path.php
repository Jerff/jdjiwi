<?php

return array(
    /*
     * Настройки
     */
    'config' => '_.config/',
    /*
     * Системная папка
     */
    'data' => cSoursePath . '.data/',
    /*
     * app 
     */
    'app.theme', cSoursePath . 'themes/core/',
    'app.ajax', cSoursePath . 'themes/core/ajax/',
    'app.controller', cSoursePath . 'themes/core/controller/',
    'app.templates', cSoursePath . 'themes/core/templates/',
    'app.page', cSoursePath . 'themes/core/templates/',
        /*
     * components 
     */
    'components', cSoursePath . 'components/',
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