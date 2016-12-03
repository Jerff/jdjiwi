<?php

namespace Jdjiwi;

use Jdjiwi\Mail\Phpmailer;

//Loader::library('mail:driver/Phpmailer');

class Mail {

    static private $driver;

    static private function driver($config) {
        if (empty(self::$driver)) {
            switch (Config::get('mail.phpmailer')) {
                case 'mysql':
                    self::$driver = new Phpmailer($config);
                    break;

                default:
                    throw new Exception('нет установлен драйвер почты');
                    exit;
            }
        }
        return self::$driver;
    }

    static public function get($config = null) {
        return self::driver($config);
    }

}
