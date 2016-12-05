<?php

namespace Jdjiwi\Form;

class Html extends Register {

    public function start() {
        $this->parent()->security()->viewStart();
        $this->parent()->error()->view();
    }

    public function end() {
        $this->parent()->security()->viewEnd();
    }

}

