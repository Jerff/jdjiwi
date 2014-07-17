<?php

require(cSoursePath . '_.system/loader/cLoader.php');
pre(get_defined_constants(true)['user']);
cConfig::pre();
cLoader::pre();
exit;