<?php

class cCompileUpdate {

    public static function start() {
        \Jdjiwi\Init::ignoreUserAbort();
        \Jdjiwi\Init::timeLimit();


        cCompile::php()->update();
        cCompile::fileJsCss()->update();
        \Jdjiwi\Init::ignoreUserAbort(false);
    }

}


