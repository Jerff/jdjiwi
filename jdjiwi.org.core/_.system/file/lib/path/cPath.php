<?php

class cPath {

    static public function modul($name) {
        return \Jdjiwi\Config::get('file.path') . str_replace('.', '/', $table) . '/';
    }

}
