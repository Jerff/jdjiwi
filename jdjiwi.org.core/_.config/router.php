<?php

return array(
    /*
     * разделов сайта
     */
    'list' => array(
        'application' => 'http://' . \Jdjiwi\Config::get('host.url'),
        'ajax' => 'http://' . \Jdjiwi\Config::get('host.url') . '/call-ajax',
        'cron' => 'http://' . \Jdjiwi\Config::get('host.url') . '/.cron',
        'compileJsCss' => 'http://' . \Jdjiwi\Config::get('host.url') . '/core-compile',
        /*
         * система администрирования
         */
        'admin' => 'http://' . \Jdjiwi\Config::get('host.url') . '/admin',
    )
);
