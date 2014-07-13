<?php

require(cSoursePath . '_.system/loader/cLoader.php');
cConfig::pre();
pre(get_defined_constants(true)['user']);
exit;



cLoader::library('cache/cmfCache');
cLoader::library('cache/cmfCacheSite');
cLoader::library('cache/cmfCacheUser');

cLoader::library('admin/cAdmin');

cLoader::library('application/cApplication');
?>