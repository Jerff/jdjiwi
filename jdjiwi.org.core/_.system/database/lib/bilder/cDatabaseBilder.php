<?php

abstract class cDatabaseBilder {

    private $mData = array();
    private $mQuery = array();

    // очищение таблиц базы
    public function truncate() {
        foreach (func_get_args() as $table) {
            $this->query('TRUNCATE TABLE ' . cDB::quote()->table($table))->compile();
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
        return $this->query('OPTIMIZE TABLE '. cDB::utility()->tableList(...func_get_args()));
    }

    private function query($query) {
        $this->mData[] = $query;
        return $this;
    }

    private function compile() {
        if (!empty($this->mData)) {
            $this->mQuery[] = implode(' ', $this->mData);
        }
        $this->mData = array();
    }

    public function exec() {
        $this->compile();
        foreach ($this->mQuery as $query) {
            $res = cDB::query($query);
        }
        return $res;
    }

}
