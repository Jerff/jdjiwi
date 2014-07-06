<?php

cLoader::library('sql/cmfMySql');
cLoader::library('patterns/cPatternsStaticRegistry');

class cRegister extends cPatternsStaticRegistry {

    // получить экземпляр cPDO
    public static function sql() {
        return self::register('cMySql');
    }

}

?>