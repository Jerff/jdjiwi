<?php

class cDatabaseQuote {

    public function quote($str) {
        return cDB::quote($str);
    }

    public function string($str) {
        return $str === null ? 'NULL' : $this->quote($str);
    }

    public function like($str) {
        return '%' . addslashes(str_replace('%', '%%', $str)) . '%';
        ;
    }

    public function int($int) {
        return (int) $int;
    }

    public function func($func) {
        foreach ($func as $key => $value) {
            if (is_string($k)) {
                $func[$key] .= ' AS ' . $v;
            }
        }
        return implode(', ', $func);
    }

    public function fields($fields) {
        foreach ($fields as $key => $value) {
            $fields[$key] = $this->param($v);
            if (is_string($k)) {
                $fields[$key] .= ' AS ' . $v;
            }
        }
        return implode(', ', $fields);
    }

    public function field($str) {
        return $this->param(param);
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
