<?php

/*
 * префиксы разделов сайта
 */
define('cAppHostUrl', cDomenUri . '');
define('cAdminHostUrl', cDomenUri . '/admin');

/*
 * адреса разделов сайта
 */
cPages::base()->set(array(
    'application' => 'http://' . cDomen . cAppHostUrl,
    'admin' => 'http://' . cDomen . cAdminHostUrl
));
define('cItemHostUrl', cPages::base()->router());

/*
 * устанавливаем константы адресов разделов
 */
define('cAppUrl', cPages::base()->application);
define('cAdminUrl', cPages::base()->admin);
define('cItemUrl', cDomen . cItemHostUrl);

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