<?php

class cCompileJsCssCall {

    static public function start() {
        cCompile::fileJsCss()->compile(\Jdjiwi\Input::get()->get('query'));
    }

}


