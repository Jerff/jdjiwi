<?php

/*
 * константы быстрого доступа
 */
// устанавливаем адреса разделов
define('cAppUrl', cPages::base()->application);
define('cAdminUrl', cPages::base()->admin);
define('cCompileUrl', cPages::base()->compileJsCss);
define('cItemUrl', cPages::base()->router());

// устанавливаем адреса для быстрого доступа к каталогам проекта
define('cBaseAppUrl', cAppUrl . '/');
define('cBaseAdminUrl', cAdminUrl . '/');
define('cBaseImgUrl', cBaseAppUrl);
?>