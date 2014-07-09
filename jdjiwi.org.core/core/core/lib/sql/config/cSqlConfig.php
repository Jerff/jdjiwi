<?php

cLoader::library('core:patterns/cPatternsRegistry');

abstract class cSqlConfig extends cPatternsRegistry {

    abstract public function init($driver);
}

?>