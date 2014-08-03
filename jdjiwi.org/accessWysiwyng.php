<?php

$old = getcwd();
chdir(__DIR__);

define('cApplication', 'wysiwyng');
require('index.php');

restore_error_handler();
chdir($old);