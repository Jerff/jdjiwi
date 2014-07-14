<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'host' => array(
        'application' => 'http://' . cConfig::get('host.url') . cConfig::get('sections.application.uri'),
        'admin' => 'http://' . cConfig::get('host.url') . cConfig::get('sections.admin.uri')
    ),
);
?>