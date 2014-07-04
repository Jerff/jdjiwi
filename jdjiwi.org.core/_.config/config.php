<?php

/*
 *  компиляция
 * 0 - режим отладки
 * при режиме > 0 уже юзается общие скомпилированные файлы для морды и админа
 * 1 - юзается общие скомпилированные файлы для морды и админа
 * 2 - режим компиляции php файлов - проверяются измененные файлы
 * 3 - режим компиляции php файлов - файлы не проверятся на изменения
 */
define('isComplile', 0);

/*
 *  определяем домен
 */
define('cDomen', 'www.core.jdjiwi.ru');
define('cHostUrl', '');

/*
 *  драйвер кеша
 */
define('cCacheTypeDriver', 'sql');

/*
 *  конфигурация мемкеша
 */
define('cMemcacheHost', 'localhost');
define('cMemcachePort', 11211);

/*
 *  Sphinx - настройки поиска
 */
define('cSphinxHost', 'localhost');
define('cSphinxPort', 3312);

/*
 * Настройки базы
 */
define('cMysqlHost', 'localhost');
define('cMysqUser', 'root');
define('cMysqPassword', 'prog12345');
define('cMysqDb', 'core_jdjiwi_ru');
define('cDbPefix', 'core_');

/*
 * настройки папок
 */
define('cSoursePath', cRootPath . 'jdjiwi.org.core/');
define('cWWWPath', cRootPath . 'jdjiwi.org/');

/*
 * Соль
 */
define('cSalt', '6z3WBO4GN8');

/*
 * права на файлы
 */
define('cFileMode', 0666);
define('cDirMode', 0777);

/*
 * ImageMagick
 */
define('isImageMagick', 1);
define('cImageMagickPath', '/usr/local/bin/');

/*
 * настройки локали
 */
setlocale(LC_ALL, array('ru_RU.utf-8', 'rus_RUS.utf-8'));

/*
 * настройки часового поиска
 */
date_default_timezone_set('Europe/Moscow');
?>