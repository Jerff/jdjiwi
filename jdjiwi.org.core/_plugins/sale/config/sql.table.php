<?php

define('db_param_discount', \Jdjiwi\Config::get('database.db.pefix') . 'param_group_discount');
define('path_discount', \Jdjiwi\Config::get('file.path') . 'discount/');

define('db_discount', \Jdjiwi\Config::get('database.db.pefix') . 'basket_discount');

// кoрзина
define('db_basket', \Jdjiwi\Config::get('database.db.pefix') . 'basket');
define('db_basket_order', \Jdjiwi\Config::get('database.db.pefix') . 'basket_order');
define('db_basket_status', \Jdjiwi\Config::get('database.db.pefix') . 'basket_status');

define('db_payment', \Jdjiwi\Config::get('database.db.pefix') . 'payment');
define('path_Payment', \Jdjiwi\Config::get('file.path') . 'pay/');
define('db_payment_log', \Jdjiwi\Config::get('database.db.pefix') . 'payment_log');
define('db_payment_transactions', \Jdjiwi\Config::get('database.db.pefix') . 'payment_transactions');

define('db_delivery', \Jdjiwi\Config::get('database.db.pefix') . 'delivery');
