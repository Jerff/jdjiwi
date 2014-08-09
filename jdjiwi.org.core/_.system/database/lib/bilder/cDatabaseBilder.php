<?php

abstract class cDatabaseBilder {

    private $mData = array();
    private $mQuery = array();

    /*
     * TRUNCATE
     */

    public function truncate() {
        foreach (func_get_args() as $table) {
            $this->query('TRUNCATE TABLE ' . cDB::quote()->table($table))->compile();
        }
        return $this;
    }

    /*
     * OPTIMIZE
     */

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

    /*
     * SELECT
     */

    public function select($fields, $function = null, $options = array()) {
        return $this->query('SELECT ' . implode(' ', $options) . cDB::quote()->fileds($fields) . ($function ? ', ' . cDB::quote()->func($fields) : '' ));
    }

    /*
     * FROM
     */

    public function from($table, $alias = null) {
        return $this->query($table . ($alias? : ''));
    }
    /*
     * JOIN
     */

    public function join($type, ...$mTable) {

    }

    /*
     * query
     */

    public function __toString() {
        $this->compile();
        return each($this->mQuery);
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
