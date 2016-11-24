<?php

use Jdjiwi\Settings;

\Jdjiwi\Loader::library('compile:cCompileConfig');
\Jdjiwi\Loader::library('compile:cCompilePhp');
\Jdjiwi\Loader::library('compile:cCompileJsCss');
\Jdjiwi\Loader::library('compile:cCompileUpdate');
\Jdjiwi\Loader::library('core:traits/StaticRegistry');

class cCompile {

    use \Jdjiwi\Traits\StaticRegistry;

    static public function is() {
        return Settings::get('compilde', 'css&js') or 1;
    }

    static public function config() {
        return self::register('cCompileConfig');
    }

    static public function php() {
        return self::register('cCompilePhp');
    }

    static public function fileJsCss() {
        return self::register('cCompileJsCss');
    }

    static public function update() {
        return self::register('cCompileUpdate');
    }

}
