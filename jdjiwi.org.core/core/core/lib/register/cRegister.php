<?php

cLoader::library('core:sql/cmfMySql');
cLoader::library('core:patterns/cPatternsStaticRegistry');

class cRegister extends cPatternsStaticRegistry {

    // получить экземпляр cPDO
    public static function sql() {
        return self::register('cMySql');
    }

}

?>