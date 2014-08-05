<?php

class cFormInt extends cFormNumber {

    public function init() {
        $this->settings()->replace('isNumber', 'isInt');
        parent::init();
    }

}
