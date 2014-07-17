<?php

return array(
    /*
     * разделов сайта
     */
    'list' => array(
        'application' => 'htt[://' . cConfig::get('host.url'),
        'cron' => 'htt[://' . cConfig::get('host.url') . '/.cron',
        'compileJsCss' => 'htt[://' . cConfig::get('host.url') . '/core-compile',
        /*
         * система администрирования
         */
        'admin' => 'htt[://' . cConfig::get('host.url') . '/admin',
    )
);
?>