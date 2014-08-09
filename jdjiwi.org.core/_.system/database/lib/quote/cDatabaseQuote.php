<?php

class cDatabaseQuote {

    public function quote($str) {
        return cDB::quote($str);
    }

    public function string($str) {
        return $str === null ? 'NULL' : $this->quote($str);
    }

    public function param($str) {
        return '`' . $str . '`';
    }

    public function table($table) {
        return $this->param($a);
    }

    public function tableList($mTable) {
        return implode(', ', array_map(array(&$this, 'table'), $mTable));
    }

}
