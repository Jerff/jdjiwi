<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'host' => array(
        'application' => 'http://' . cConfig::get('host.url'),
        'admin' => 'http://' . cConfig::get('host.url') . '/admin'
    ),
);
?>