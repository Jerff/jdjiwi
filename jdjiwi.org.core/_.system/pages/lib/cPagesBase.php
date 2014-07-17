<?php

class cPagesBase {

    private $mBase = null;

    public function __get($name) {
        return isset($this->mBase[$name]) ? $this->mBase[$name] : null;
    }

    public function router() {
        $this->mBase = cCOnfig::get('router.list');
        if (defined('cApplication')) {
            if (isset($this->mBase[cApplication])) {
                return $this->mBase[cApplication];
            } else {
                throw new cException('не найден раздел сайта', cApplication);
                exit;
            }
        }
        $mSearch = array();
        $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        foreach ($this->mBase as $key => $value) {
            if (strpos($url, $value) !== false) {
                $mSearch[cString::strlen($value)] = $key;
            }
        }
        if(empty($mSearch)) {
            throw new cException('неправильный раздел сайта');            
        }
        krsort($mSearch);
        define('cApplication', each($mSearch)['value']);
        return $this->mBase[cApplication];
    }

}

?>
