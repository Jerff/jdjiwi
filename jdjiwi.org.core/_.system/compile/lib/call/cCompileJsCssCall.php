<?php

class cCompileJsCssCall {

    static public function start() {
        cCompile::fileJsCss()->compile(\Jdjiwi\Input\Get::get('query'));
    }

}


