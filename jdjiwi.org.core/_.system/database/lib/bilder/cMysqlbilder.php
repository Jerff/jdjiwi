<?php

\Jdjiwi\Loader::library('database:bilder/cDatabaseBilder');

class cMysqlBilder extends cDatabaseBilder {

    public function selectCalcFoundRows() {
        return $this->options('SQL_CALC_FOUND_ROWS')->config('SQL_CALC_FOUND_ROWS')->select(...func_get_args());
    }

    public function initResult(&$res) {
        if ($this->isConfig('SQL_CALC_FOUND_ROWS')) {
            $res->setCalcFoundRows((int) cDB::query('SELECT FOUND_ROWS()')->fetchRow(0));
        }
    }

}
