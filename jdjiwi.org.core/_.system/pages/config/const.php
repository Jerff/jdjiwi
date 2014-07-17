<?php

/*
 * константы быстрого доступа
 */
// устанавливаем адреса разделов
define('cAppUrl', cPages::base()->application . '/');
define('cAdminUrl', cPages::base()->admin . '/');
define('cCompileUrl', cPages::base()->compileJsCss . '/');
define('cItemUrl', cPages::base()->router() . '/');
define('cImgUrl', cBaseAppUrl);
?>