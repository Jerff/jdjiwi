<?php

return array(
    /*
     * разделов сайта
     */
    'list' => array(
        'application' => 'http://' . cConfig::get('host.url'),
        'cron' => 'http://' . cConfig::get('host.url') . '/.cron',
        'compileJsCss' => 'http://' . cConfig::get('host.url') . '/core-compile',
        /*
         * система администрирования
         */
        'admin' => 'http://' . cConfig::get('host.url') . '/admin',
    )
);
?>