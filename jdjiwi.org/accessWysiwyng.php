<?php

$old = getcwd();
chdir(__DIR__);

define('cApplication', 'wysiwyng');
require('index.php');

chdir($old);
?>