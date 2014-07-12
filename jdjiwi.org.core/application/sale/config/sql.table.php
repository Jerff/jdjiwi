<?php

define('db_param_discount', cConfig::get('database.db.pefix') . 'param_group_discount');
define('path_discount', cConfig::get('file.path') . 'discount/');

define('db_discount', cConfig::get('database.db.pefix') . 'basket_discount');

// кoрзина
define('db_basket', cConfig::get('database.db.pefix') . 'basket');
define('db_basket_order', cConfig::get('database.db.pefix') . 'basket_order');
define('db_basket_status', cConfig::get('database.db.pefix') . 'basket_status');

define('db_payment', cConfig::get('database.db.pefix') . 'payment');
define('path_Payment', cConfig::get('file.path') . 'pay/');
define('db_payment_log', cConfig::get('database.db.pefix') . 'payment_log');
define('db_payment_transactions', cConfig::get('database.db.pefix') . 'payment_transactions');

define('db_delivery', cConfig::get('database.db.pefix') . 'delivery');
?>