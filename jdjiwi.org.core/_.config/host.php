<?php

return array(
    /*
     *  определяем домен
     */
    'develop' => array(
        'url' => "www.develop.core.jdjiwi.ru",
        'app.theme' => cSoursePath . 'themes/core/',
    ),
    'test-application' => array(
        'url' => "www.core.jdjiwi.ru:8080/test-application",
        'app.theme' => cSoursePath . 'themes/core/',
    ),
    'test-application-2' => array(
        'url' => "www.core.jdjiwi.ru/test-application",
        'app.theme' => cSoursePath . 'themes/core/',
    ),
    'production' => array(
        'url' => "www.core.jdjiwi.ru",
        'app.theme' => cSoursePath . 'themes/core/',
    ),
);
