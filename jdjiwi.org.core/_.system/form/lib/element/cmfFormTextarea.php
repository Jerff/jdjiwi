<?php

class cmfFormTextarea extends cFormText {

    protected function init($o) {
        $this->setFilter('cmfFilterLenMax', cmfFormTextareaMax);
        parent::init($o);
    }

    public function html($param, $style = '') {
        return '<textarea name="' . ($name = $this->getId()) . '" id="' . $name . '" ' . $style . '>' . \Jdjiwi\String::specialchars($this->getValue()) . '</textarea>';
    }

}

class cmfFormTextareaWysiwyng extends cFormText {

    private $path;
    private $number;

    function __construct($path, $number, $o = null) {
        $this->path = $path;
        $this->number = $number;
        parent::__construct($o);
    }

    public function html($param, $height = null) {
        return \Jdjiwi\Wysiwyng::html($this->path, $this->number, $this->getId(), $this->getValue(), $height);
    }

    public function jsUpdate() {
        return parent::jsUpdate() . \Jdjiwi\Wysiwyng::jsUpdate($this->getId(), $this->getValue());
    }

}

