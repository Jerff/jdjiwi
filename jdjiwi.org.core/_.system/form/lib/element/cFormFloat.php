<?php

class cFormFloat extends cFormNumber {

    public function init() {
        $this->settings()->replace('isNumber', 'isFloat');
        parent::init();
    }

}
