<?php

cLoader::library('database:quote/cDatabaseQuote');

abstract class cDatabase {

    private $mRegister = array();

    protected function &register($class) {
        if (empty($this->mRegister[$class])) {
            $this->mRegister[$class] = new $class();
        }
        return $this->mRegister[$class];
    }

    abstract protected function driver();

    abstract protected function placeholder();

    abstract protected function bilder();

    abstract protected function utility();

    /*
     * работа с БД
     */

    public function query($query) {
        try {
            if (cDebug::isSql()) {
                $t = cSystem::microtime();
            }
            if ($res = $this->driver()->query($query)) {
                if (cDebug::isSql()) {
                    cLog::sql(trim($query), cSystem::microtime() - $t);
                    if (cDebug::isExplain() and ( stripos($query, 'SELECT') !== false)) {
                        $exp = $this->driver()->query('EXPLAIN ' . $query)->fetchAssocAll();
                        $query = '<b>EXPLAIN</b> ' . $query;
                        foreach ($exp as $r) {
                            $query .= "\n" . print_r($r, true);
                        }
                        cLog::explain($query);
                    }
                }
            } else {
                throw new cDatabaseException($query, $this->driver()->errorInfo());
            }
        } catch (cDatabaseException $e) {
            $e->errorLog();
        }
        return $res;
    }

    public function lastInsertId() {
        return $this->driver()->lastInsertId();
    }

    public function getClientVersion() {
        return $this->driver()->getAttribute(PDO::ATTR_CLIENT_VERSION);
    }

    /*
     * quote
     */

    public function quote($str = null) {
        if (empty($str)) {
            return $this->driver()->quote($str);
        } else {
            return $this->register('cDatabaseQuote');
        }
    }

}
