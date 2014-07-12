<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'router' => cPages::base()->router(),
    'app' => cPages::base()->application,
    'admin' => cPages::base()->admin,
    'item' => cConfig::get('host.url') . cConfig::get('url.item.host'),
);
//define('cItemHostUrl', cPages::base()->router());

/*
 * устанавливаем константы адресов разделов
 */
define('cAppUrl', cPages::base()->application);
define('cAdminUrl', cPages::base()->admin);
define('cItemUrl', cConfig::get('host.url') . cConfig::get('url.router'));

/*
 * устанавливаем адреса для быстрого доступа к каталогам проекта
 */
define('cBaseAppUrl', cConfig::get('url.app') . '/');
define('cBaseAdminUrl', cAdminUrl . '/');
define('cBaseImgUrl', cBaseAppUrl);

/*
 * ajax
 */
define('cAjaxUrl', cBaseAppUrl . 'callAjax/');
?>