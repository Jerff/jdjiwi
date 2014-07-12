<?php

class cCompileUpdate {

    public static function start() {
        cInit::ignoreUserAbort();
        cInit::timeLimit();


        cCompile::php()->update();
        cCompile::fileJsCss()->update();
        cInit::ignoreUserAbort(false);
    }

}

?>
