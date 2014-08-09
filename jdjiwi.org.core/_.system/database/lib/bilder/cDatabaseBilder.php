<?php

abstract class cDatabaseBilder {

    private $query = null;
    private $mQuery = array();

    // очищение таблиц базы
    public function truncate() {
        foreach (func_get_args() as $table) {
            $this->mQuery[] = 'TRUNCATE TABLE ' . cDB::quote()->table($table);
        }
        return $this;
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
            $mTable = cDB::utility()->tableList();
        }
        return $this->query('TRUNCATE TABLE '. cDB::utility()->tableList(...func_get_args()));
    }

    private function query($query) {
        $this->query .= $query;
        return $this;
    }

    public function exec() {
        if (empty($this->mQuery)) {
            return cDB::query($this->query);
        } else {
            foreach ($this->mQuery as $query) {
                $res = cDB::query($query);
            }
            return $res;
        }
    }

}
