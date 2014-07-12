<?php

/*
 * префиксы разделов сайта
 */
define('cAppHostUrl', cConfig::get('application.domen.uri') . '');
define('cAdminHostUrl', cConfig::get('application.domen.uri') . '/admin');

/*
 * адреса разделов сайта
 */
cPages::base()->set(array(
    'application' => 'http://' . cConfig::get('application.domen') . cAppHostUrl,
    'admin' => 'http://' . cConfig::get('application.domen') . cAdminHostUrl
));
define('cItemHostUrl', cPages::base()->router());

/*
 * устанавливаем константы адресов разделов
 */
define('cAppUrl', cPages::base()->application);
define('cAdminUrl', cPages::base()->admin);
define('cItemUrl', cConfig::get('application.domen') . cItemHostUrl);

/*
 * устанавливаем адреса для быстрого доступа к каталогам проекта
 */
define('cBaseAppUrl', cAppUrl . '/');
define('cBaseAdminUrl', cAdminUrl . '/');
define('cBaseImgUrl', cBaseAppUrl);

/*
 * ajax
 */
define('cAjaxUrl', cBaseAppUrl . 'callAjax/');
?>