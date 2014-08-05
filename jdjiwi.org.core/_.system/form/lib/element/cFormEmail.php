<?php

class cFormEmail extends cFormText {

    public function init() {
        parent::init();
        $this->settings()->isEmail();
    }

}
