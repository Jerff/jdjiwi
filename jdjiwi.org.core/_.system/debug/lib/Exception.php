<?php

namespace Jdjiwi;

Loader::library('debug:exception/Error');
Loader::library('core:jString');

class Exception extends \Exception {
    /*
      final function getMessage(); // сообщение исключения
      final function getCode(); // код исключения
      final function getFile(); // файл из которого брошено исключение
      final function getLine(); // строка бросания
      final function getTrace(); // массив стека вызовов
      final function getTraceAsString(); // массив стека вызовов отформатированый в строку
     */

    protected $name = 'Исключение';

    public function __construct($message, $param = null, $code = null, $previous = null) {
        if (!empty($param)) {
            $message .= ': <em>' . print_r($param, true) . '</em>';
//            $message = '<em>'. $message .'</em> ' . print_r($param, true);
        }
        parent::__construct($message, $code, $previous);
    }

    protected function getName() {
        return $this->name;
    }

    protected function updateMessage($message) {
        if (!empty($message)) {
            $this->message = $message . ': ' . $this->message;
        }
    }

    protected function getCodeName() {
        return $this->getCode();
    }

    public function addError($message = false) {
        $this->updateMessage($message);
        Log::error((string) $this);
    }

    public function addErrorLog($message = false) {
        $this->updateMessage($message);
        Log::addError((string) $this);
    }

    static public function parseTrace($trace) {
        if (class_exists('\Jdjiwi\String', false)) {
            return jString::specialchars(trim(preg_replace('~^(.*)(#5 (.*))$~ms', '$1', $trace)));
        } else {
            return htmlspecialchars(trim(preg_replace('~^(.*)(#5 (.*))$~ms', '$1', $trace)), ENT_QUOTES, Config::get('i18n.charset'));
        }
    }

    public function __toString() {
        $code = $this->getCodeName();
        return '<b><big>' . $this->getName() . ':</big></b> '
                . (empty($code) ? '' : $code . ': ')
                . $this->getMessage()
                . ' in ' . $this->getFile() . ':' . $this->getLine()
                . PHP_EOL . self::parseTrace($this->getTraceAsString());
    }

}

