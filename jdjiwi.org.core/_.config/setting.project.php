<?php

/*
 * Кодировки
 */
define('cCharset', 'UTF-8');
setlocale(LC_ALL, array('ru_RU.utf-8', 'rus_RUS.utf-8'));
if (extension_loaded('mbstring')) {
    ini_set('mbstring.language', 'Russian');
    ini_set('mbstring.internal_encoding', cCharset);
}

/*
 * Настройки
 */
define('cConfigPath', cSoursePath . '_.config/');

/*
 * Системная папка
 */
define('cDataPath', cSoursePath . '.data/');

// места для кеша
define('cCacheSitePath', cWWWPath . '.cache/cache/');
define('cCachePagePath', cDataPath . 'cache/page/');
define('cCacheSQLitePath', cDataPath . 'cache/SQLite/mydb.sq3');


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

// компилированный код
define('cCompilePath', cDataPath . 'compile/');

// папка с upload файлами
define('cFilePath', 'files/');
?>