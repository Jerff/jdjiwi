<?php

cLoader::library('core:sql/mysql/cMySql');
cLoader::library('core:patterns/cPatternsStaticRegistry');

class cRegister extends cPatternsStaticRegistry {

    // получить экземпляр cPDO
    public static function sql() {
        return self::register('cMySql');
    }

}

?>