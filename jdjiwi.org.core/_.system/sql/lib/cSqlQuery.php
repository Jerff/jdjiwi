<?php

cLoader::library('core:patterns/cPatternsRegistry');

abstract class cSqlQuery extends cPatternsRegistry {

    private $mQuery = array();

    private function compile() {
        pre(self::$mQuery);
        return 'SELECT 1';
    }

    public function exec() {
        return $this->parent()->query($this->compile());
    }

}

?>