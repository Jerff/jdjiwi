<?php

use Jdjiwi\Exception,
    \Jdjiwi\Log,
    \Jdjiwi\Config;

class cPagesBase {

    private $mBase = null;

    public function __get($name) {
        return isset($this->mBase[$name]) ? $this->mBase[$name] : null;
    }

    public function router() {
        $this->mBase = Config::get('router.list');
        try {
            if (defined('cApplication')) {
                if (isset($this->mBase[cApplication])) {
                    return $this->mBase[cApplication];
                } else {
                    throw new Exception('не найден раздел сайта', cApplication);
                    exit;
                }
            }
            $mSearch = array();
            $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . \Jdjiwi\Config::get('host.uri');
            foreach ($this->mBase as $key => $value) {
                if (strpos($url, $value) !== false) {
                    $mSearch[\Jdjiwi\jString::strlen($value)] = $key;
                }
            }
            if (empty($mSearch)) {
                throw new Exception('неправильный раздел сайта');
            }
            krsort($mSearch);
            define('cApplication', each($mSearch)['value']);
        } catch (Exception $e) {
            Log::addError($e);
            if (!defined('cApplication')) {
                define('cApplication', 'application');
            }
        }
        return $this->mBase[cApplication];
    }

}
