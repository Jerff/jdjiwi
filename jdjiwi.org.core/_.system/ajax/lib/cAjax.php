<?php

\Jdjiwi\Loader::library('core:input/cInput');
\Jdjiwi\Loader::library('ajax:cAjaxResponse');

class cAjax {

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
            $r = new cAjaxResponse();
        }
        return $r;
    }

    static public function is() {
        if (cInput::post()->get('isAjax')) {
            self::start();
        }
        return self::$start;
    }

    static public function getUrl() {
        return (string) cInput::post()->get('ajaxUrl');
    }

    static public function isCommand($command = null) {
        if ($command) {
            return cInput::post()->get('ajaxCommand') === $command;
        } else {
            return cInput::post()->is('ajaxCommand');
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
        if (\Jdjiwi\Debug::isAjax()) {
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
        if (\Jdjiwi\Debug::isView()) {
            $result['debug'] = array(
                'is' => true,
                'log' => $content . \Jdjiwi\Log::message()
            );
        }
        echo json_encode($result);
    }

}
