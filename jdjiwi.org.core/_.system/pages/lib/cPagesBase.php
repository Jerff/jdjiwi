<?php

class cPagesBase {

    private $mBase = null;

    public function set($mBase) {
        $this->mBase = $mBase;
    }

    public function __get($name) {
        return isset($this->mBase[$name]) ? $this->mBase[$name] : null;
    }

    public function router() {
        $list = cCOnfig::get('router.list');
        if (isset($list[cApplication])) {
            return $list[cApplication];
        }
        throw new cException('неправильный раздел сайта', cApplication);
        exit;
    }

}

?>
