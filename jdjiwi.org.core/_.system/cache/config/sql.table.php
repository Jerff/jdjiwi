<?php

// кеш меню админки
define('db_admin_cache', cConfig::get('database.db.pefix') . 'sys_cache_admin');
// кеш данных
define('db_cache_data', cConfig::get('database.db.pefix') . 'sys_cache_data');
// обновление кеша
define('db_cache_update', cConfig::get('database.db.pefix') . 'sys_cache_update');
?>