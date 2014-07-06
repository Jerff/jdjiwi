<?php

require(cCorePath . 'core/loader/cLoader.php');
cModul::load('core:core');
cModul::load('core:seo');



cLoader::library('system/function');
cLoader::library('register/cRegister');

cLoader::library('file/cDir');
cLoader::library('file/cFile');

cLoader::library('pages/cPages');
cLoader::library('setting.pages');
cLoader::library('setting.application');
cLoader::library('sql.table');

cLoader::library('cache/cmfCache');
cLoader::library('cache/cmfCacheSite');
cLoader::library('cache/cmfCacheUser');

cLoader::library('admin/cAdmin');

cModul::load('compile/cCompile');
cLoader::library('application/cApplication');
?>