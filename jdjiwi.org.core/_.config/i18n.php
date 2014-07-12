<?php

return array(
    /*
     * Кодировки
     */
    'charset' => 'UTF-8',
    'locale' => array('ru_RU.utf-8', 'rus_RUS.utf-8'),
    'mbstring.language' => 'Russian',
);

define('cCharset', 'UTF-8');
setlocale(LC_ALL, array('ru_RU.utf-8', 'rus_RUS.utf-8'));
if (extension_loaded('mbstring')) {
    ini_set('mbstring.language', 'Russian');
    ini_set('mbstring.internal_encoding', cCharset);
}
?>