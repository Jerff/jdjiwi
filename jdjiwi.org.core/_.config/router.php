<?php

return array(
    /*
     * разделов сайта
     */
    'list' => array(
        'application' => cCOnfig::get('sections.application.uri'),
        'cron' => cCOnfig::get('sections.application.uri'),
        'ajax' => cCOnfig::get('sections.application.uri'),
        'compileJsCss' => cCOnfig::get('sections.application.uri'),
        /*
         * система администрирования
         */
        'admin' => cCOnfig::get('sections.admin.uri'),
    )
);
?>