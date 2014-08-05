<?php

class cFormRange extends cFormNumber {

    public function init() {
        parenet::init();
        $this->settings()->dataType('range');
    }

}
