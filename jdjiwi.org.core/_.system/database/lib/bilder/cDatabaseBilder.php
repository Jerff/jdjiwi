<?php

abstract class cDatabaseBilder {

    private $mConfig = array();
    private $options = '';
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
        return $this->query('OPTIMIZE TABLE ' . cDB::utility()->tableList(...func_get_args()));
    }

    /*
     * SELECT
     */

    abstract public function selectCalcFoundRows($fields);

    public function select($fields) {
        return $this->query('SELECT ' . $this->getOptions() . self::parseFields($fields));
    }

    static protected function parseFields($fields, $sep = 'AS') {
        $sep = ' ' . $sep . ' ';
        foreach ($fields as $key => $value) {
            $fields[$key] = $this->param($v);
            if (is_array($value) and $key === 'function') {
                foreach ($value as $k => $v) {
                    $fields[] = $k . ' AS ' . $v;
                }
            } else if (is_string($k)) {
                $fields[$key] = $this->field($k) . ' AS ' . $value;
            }
        }
        return implode(', ', $fields);
    }

    /*
     * FROM
     */

    public function from($table, $alias = null) {
        return $this->query(cDB::quote()->table($table) . ($alias ? ' AS ' . $alias : ''));
    }

    /*
     * CONFIG
     */

    public function config($key, $value = true) {
        $mConfig[$key] = $value;
        return $this;
    }

    public function isConfig($key) {
        return isset(self::$mConfig[$key]);
    }

    public function getConfig($key) {
        return get(self::$mConfig, $key);
    }

    /*
     * OPTIONS
     */

    public function options() {
        switch (func_num_args()) {
            case 0:
                break;

            case 1:
                $this->options = func_get_arg(0);
                break;

            default:
                $this->options = func_get_args();
                break;
        }
        return $this;
    }

    public function getOptions() {
        if (empty($this->options)) {
            return '';
        }
        $options = $this->options;
        $this->options = '';
        return ' ' . implode(' ', $options) . ' ';
    }

    /*
     * UNION
     */

    public function union() {
        return $this->query('(' . implode(') UNION (', func_get_args() . ')'));
    }

    /*
     * JOIN
     */

    public function join($table, $alias = null) {
        return $this->query($this->getOptions() . ' JOIN ' . cDB::quote()->table($table) . ($alias ? ' AS ' . $alias : ''));
    }

    public function on() {
        return $this->query(' ON (' . $this->parseWhere(...func_get_args()) . ')');
    }

    /*
     * SORT
     */

    public function orderBy() {
        return $this->query(' ORDER BY ' . $this->parseOrderBy(...func_get_args()));
    }

    protected function parseOrderBy() {
        
    }

    /*
     * WHERE
     */

    public function where() {
        return $this->query(' WHERE ' . $this->parseWhere(...func_get_args()));
    }

    protected function parseWhere() {
        
    }

    /*
     * LIMIT
     */

    public function limit($offset, $count = null) {
        return $this->query('LIMIT ' . (int) $offset . ($count ? ', ' . (int) $count : ''));
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
        $this->initResult($res);
        return $res;
    }

    public function initResult(&$res) {
        
    }

}
