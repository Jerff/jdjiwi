<?php

class cCompileJsCssCall {

    static public function start() {
        cCompile::fileJsCss()->compile(cInput::get()->get('query'));
    }

}


