<?php

cLoader::library('core:sql/cMySql');
cLoader::library('core:patterns/cPatternsStaticRegistry');

class cRegister extends cPatternsStaticRegistry {

    // получить экземпляр cPDO
    public static function sql() {
        return self::register('cMySql');
    }

}

?>