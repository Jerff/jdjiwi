<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'app' => cPages::base()->application .'/',
    'compileJsCss' => cPages::base()->compileJsCss .'/',
    'admin' => cPages::base()->admin .'/',
    'item' => cPages::base()->router() .'/',
);
?>