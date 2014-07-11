<?php

/*
 * Настройки
 */
define('cConfigPath', '_.config/');

/*
 * Системная папка
 */
define('cDataPath', cSoursePath . '.data/');

/* app */
define('cAppPathTheme', cSoursePath . 'themes/core/');
define('cAppPathAjax', cAppPathTheme . 'ajax/');
define('cAppPathController', cAppPathTheme . 'controller/');
define('cAppPathTemplates', cAppPathTheme . 'templates/');
define('cAppPathPage', cAppPathTheme . 'templates/');

/* components */
define('cComponentsPath', cSoursePath . 'components/');

/* admin */
define('cAdminPath', cSoursePath . 'admin/');
define('cModulesPath', cSoursePath . 'modules/');
?>