<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'host' => array(
        'application' => 'http://' . cConfig::get('host.url') . cConfig::get('pages.application.uri'),
        'admin' => 'http://' . cConfig::get('host.url') . cConfig::get('pages.admin.uri')
    ),
);
?>