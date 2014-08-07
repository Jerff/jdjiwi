<?php

cLoader::library('patterns:cPatternsRegistry');
cLoader::library('sql:cSqlPlaceholder');

abstract class cSql extends cPatternsRegistry {

    abstract protected function driver();

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
                throw new cSqlException($query, $this->driver()->errorInfo());
            }
        } catch (cSqlException $e) {
            $e->errorLog();
        }
        return $res;
    }

    public function getAttribute($attr) {
        return $this->driver()->getAttribute($attr);
    }

    public function lastInsertId() {
        return $this->driver()->lastInsertId();
    }

    public function getClientVersion() {
        return $this->getAttribute(PDO::ATTR_CLIENT_VERSION);
    }

    /*
     * placeholder
     */

    public function placeholder() {
        return $this->register('cSqlPlaceholder')->query(...func_get_args());
    }

    /*
     * quote
     */

    public function quote($str) {
        return $this->driver()->quote($str);
    }

    public function quoteString($str) {
        return $str === null ? 'NULL' : $this->quote($str);
    }

    public function quoteParam($str) {
        return '`' . $str . '`';
    }

    /*
     * Утилиты
     */

    protected function util() {
        return $this->register('cSqlUtil');
    }

}
