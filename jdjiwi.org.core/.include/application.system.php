<?php

require(cSoursePath . '_.system/loader/cLoader.php');
exit;



cLoader::library('pages/cPages');
cLoader::library('setting.pages');
cLoader::library('setting.application');
cLoader::library('sql.table');

cLoader::library('cache/cmfCache');
cLoader::library('cache/cmfCacheSite');
cLoader::library('cache/cmfCacheUser');

cLoader::library('admin/cAdmin');

cModul::load('compile');
cLoader::library('application/cApplication');
?>