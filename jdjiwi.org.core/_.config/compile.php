<?php

return array(
    /*
     *  компиляция
     * 0 - режим отладки
     * при режиме > 0 уже юзается общие скомпилированные файлы для морды и админа
     * 1 - юзается общие скомпилированные файлы для морды и админа
     * 2 - режим компиляции php файлов и модулей - проверяются измененные файлы
     * 3 - режим компиляции php файлов - файлы не проверятся на изменения
     */
    'is' => 0,
    /*
     * компилированный код
     */
    'path' => __DIR__ . '/../.data/compile/'
);
//define('isComplile', 0);
//define('cCompilePath', __DIR__ . '/../.data/compile/');
?>