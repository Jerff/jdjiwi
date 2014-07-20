<?php

return array(
    /*
     * Настройки базы
     */
    'driver' => 'KCKeditor',
    'path' => cConfig::get('file.path') . '/wysiwyng',
    'salt' => 'Qg7iQRwc0sH3hYbQleU7',
    'KCKeditor.path' => cWWWPath . 'library/kckeditor/',
    'KCKeditor.app.url' => cAppUrl . 'library/kckeditor/',
);
?>