<?php

define('db_price_yandex', cConfig::get('database.db.pefix') . 'price_yandex');

define('db_showcase', cConfig::get('database.db.pefix') . 'showcase');
define('db_showcase_list', cConfig::get('database.db.pefix') . 'showcase_list');
define('path_showcase', cConfig::get('file.path') . 'showcase/');

define('db_section', cConfig::get('database.db.pefix') . 'catalog');
define('db_section_is_brand', cConfig::get('database.db.pefix') . 'catalog_is_brand');
define('db_brand', cConfig::get('database.db.pefix') . 'catalog_brand');
define('db_size', cConfig::get('database.db.pefix') . 'catalog_size');
define('path_catalog', cConfig::get('file.path') . 'catalog/');


define('db_product', cConfig::get('database.db.pefix') . 'product');
define('db_product_id', cConfig::get('database.db.pefix') . 'product_id');
define('db_product_url', cConfig::get('database.db.pefix') . 'product_url');
define('db_product_image', cConfig::get('database.db.pefix') . 'product_image');
define('db_product_attach', cConfig::get('database.db.pefix') . 'product_attach');
define('db_product_dump', cConfig::get('database.db.pefix') . 'product_dump');
define('db_product_dump_log', cConfig::get('database.db.pefix') . 'product_dump_log');
define('path_product', cConfig::get('file.path') . 'product/');
define('path_special', cConfig::get('file.path') . 'product/special/');
define('path_watermark', cConfig::get('file.path') . 'watermark/');


define('db_param_group', cConfig::get('database.db.pefix') . 'param_group');
define('db_param_group_select', cConfig::get('database.db.pefix') . 'param_group_select');
define('db_param_group_notice', cConfig::get('database.db.pefix') . 'param_group_notice');
define('db_color', cConfig::get('database.db.pefix') . 'param_group_color');

define('db_param_discount', cConfig::get('database.db.pefix') . 'param_group_discount');
define('path_discount', cConfig::get('file.path') . 'discount/');

define('db_discount', cConfig::get('database.db.pefix') . 'basket_discount');

define('db_param', cConfig::get('database.db.pefix') . 'param');
define('db_param_select', cConfig::get('database.db.pefix') . 'param_select');
define('db_param_checkbox', cConfig::get('database.db.pefix') . 'param_checkbox');
?>