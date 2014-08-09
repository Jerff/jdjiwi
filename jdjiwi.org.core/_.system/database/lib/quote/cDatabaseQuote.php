<?php

cLoader::library('database:registry/cDatabaseRegistry');

class cDatabaseQuote extends cDatabaseRegistry {

    public function quote($str) {
        return $this->DB()->quote($str);
    }

    public function quoteString($str) {
        return $str === null ? 'NULL' : $this->quote($str);
    }

    public function quoteParam($str) {
        return '`' . $str . '`';
    }

    public function quoteTable($mTable) {
        $str = '';
        $sep = '';
        while (list($k, $v) = each($a)) {
            $str .= $sep . $this->quoteParam($v);
            $sep = ', ';
        }
        return $str;
    }

}
