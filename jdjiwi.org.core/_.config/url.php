<?php

return array(
    /*
     * префиксы разделов сайта
     */
    'item' => \Jdjiwi\Pages::base()->router() . '/',
    'app' => \Jdjiwi\Pages::base()->application . '/',
    'ajax' => \Jdjiwi\Pages::base()->ajax . '/',
    'compile' => array(
        'jsCss' => \Jdjiwi\Pages::base()->compileJsCss . '/'
    ),
    'admin' => \Jdjiwi\Pages::base()->admin . '/',
);
