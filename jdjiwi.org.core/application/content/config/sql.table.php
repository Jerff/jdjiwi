<?php

define('db_main', cConfig::get('database.db.pefix') . 'main');
define('db_main_image', cConfig::get('database.db.pefix') . 'main_image');
define('path_image', cConfig::get('file.path') . 'image/');

define('db_menu', cConfig::get('database.db.pefix') . 'menu');

define('db_content', cConfig::get('database.db.pefix') . 'content');
define('db_content_pages', cConfig::get('database.db.pefix') . 'content_pages');
define('db_content_info', cConfig::get('database.db.pefix') . 'content_info');
define('db_content_static', cConfig::get('database.db.pefix') . 'content_static');
define('db_content_url', cConfig::get('database.db.pefix') . 'content_url');
?>