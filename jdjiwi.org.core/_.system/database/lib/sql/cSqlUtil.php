<?php

cLoader::library('patterns:cPatternsRegistry');

class cSqlUtil extends cPatternsRegistry {

    // количество рядов
    public function getFoundRows() {
        return (int) $this->query('SELECT FOUND_ROWS()')->fetchRow(0);
    }

    // список все таблиц базы
    public function getTableList() {
        $res = $this->DB()->query("SHOW TABLES")->fetchRowAll();
        $mTable = array();
        while (list(, list($row)) = each($res)) {
            $mTable[$row] = $row;
        }
        return $mTable;
    }

    // очищение таблиц базы
    public function truncate() {
        foreach (func_get_args() as $t) {
            $this->DB()->placeholder("TRUNCATE TABLE ?t", $t);
        }
    }

    // оптимизация таблиц базы
    public function optimize() {
        if (func_num_args()) {
            $mTable = array();
            foreach (func_get_args() as $value) {
                if (is_string($value)) {
                    $mTable[] = $value;
                } else {
                    $mTable = array_merge($mTable, (array) $value);
                }
            }
        } else {
            $mTable = $this->getTableList();
        }
        $this->placeholder("OPTIMIZE TABLE ?t%", $mTable);
    }

}

