<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'host' => array(
        'application' => 'http://' . cConfig::get('host.url') . cAppHostUrl,
        'admin' => 'http://' . cConfig::get('host.url') . cAdminHostUrl
    ),
);
?>