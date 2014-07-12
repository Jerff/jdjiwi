<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'app' => cPages::base()->application,
    'admin' => cPages::base()->admin,
    'item' => cConfig::get('host.url') . cPages::base()->router(),
    'itemUri' => cPages::base()->router(),
);
?>