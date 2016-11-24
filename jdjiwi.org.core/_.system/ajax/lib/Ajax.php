<?php

namespace Jdjiwi;

Loader::library('ajax:Response');

class Ajax {

    static private $start = false;
    static private $message = false;

    static public function start() {
        if (self::$start)
            return;
        self::$start = true;
        ob_start();
    }

    static public function get() {
        static $r = false;
        if (empty($r)) {
            $r = new Ajax\Response();
        }
        return $r;
    }

    static public function is() {
        if (Input::post()->get('isAjax')) {
            self::start();
        }
        return self::$start;
    }

    static public function getUrl() {
        return (string) Input::post()->get('ajaxUrl');
    }

    static public function isCommand($command = null) {
        if ($command) {
            return Input::post()->get('ajaxCommand') === $command;
        } else {
            return Input::post()->is('ajaxCommand');
        }
    }

    static public function error($title, $text = '') {
        self::$message = array(
            'title' => $title,
            'text' => $text
        );
        exit;
    }

    static public function shutdown() {
        if (Debug::isAjax()) {
            pre(
                    self::get()->log()
            );
        }
        $result = array();
        if (empty(self::$message)) {
            $result['ok'] = true;
            $result['result'] = self::get()->result();
        } else {
            $result['error'] = self::$message;
        }
        $content = ob_get_clean();
        if (Debug::isView()) {
            $result['debug'] = array(
                'is' => true,
                'log' => $content . Log::message()
            );
        }
        echo json_encode($result);
    }

}
