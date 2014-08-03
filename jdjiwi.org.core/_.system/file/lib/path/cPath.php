<?php

class cPath {

    static public function modul($name) {
        return cConfig::get('file.path') . str_replace('.', '/', $table) . '/';
    }

}

