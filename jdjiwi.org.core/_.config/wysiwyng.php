<?php

return array(
    /*
     * Настройки базы
     */
    'driver' => 'tinymce',
    'path' => cConfig::get('file.path') . '/wysiwyng',
    'salt' => 'Qg7iQRwc0sH3hYbQleU7',
    'filemanager.app.url' => cAppUrl . 'library/filemanager/',
    'filemanager.app.key' => 'akey',
    'kckeditor.app.url' => cAppUrl . 'library/kckeditor/',
    'tinymce.app.url' => cAppUrl . 'library/tinymce/',
);
