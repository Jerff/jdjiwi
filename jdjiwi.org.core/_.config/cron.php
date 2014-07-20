<?php

return array(
    /*
     * список задач
     */
    'status' => cConfig::get('path.data') . '/cron/cron.run',
    'list' => array(
        'file:clearTmp' => 'Удаление временных файлов',
        'cache:update' => 'Обновление кеша',
        'sitemap:update' => 'Генерация siteMap',
        'user:activate' => 'Удаление неактивированных аккурантов пользователей',
        'sale:Yandex.Market' => 'Генерация Yandex.Market',
        'subscribe:send' => 'Рассылка',
        'backup:update' => 'Резервное копирование',
    )
);
?>