<?php

/*
 * константы быстрого доступа
 */
// устанавливаем адреса разделов
define('cAppUrl', cPages::base()->application);
define('cAdminUrl', cPages::base()->admin);
define('cItemUrl', cConfig::get('host.url') . cConfig::get('url.itemUri'));

// устанавливаем адреса для быстрого доступа к каталогам проекта
define('cBaseAppUrl', cAppUrl . '/');
define('cBaseAdminUrl', cAdminUrl . '/');
define('cBaseImgUrl', cBaseAppUrl);
?>