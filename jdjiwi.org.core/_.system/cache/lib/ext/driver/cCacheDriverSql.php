<?php

cLoader::library('cache:ext/driver/cCacheDriver');
cLoader::library('core:crypt/cCrypt');

class cCacheDriverSql extends cCacheDriver {

    // ресурс базы данных
    private $res = null;

    protected function setResurse($res) {
        $this->res = $res;
    }

    private function getResurse() {
        return $this->res;
    }

    //функция хеширования
    protected function hash($n) {
        return cCrypt::crc32($n);
    }

    protected function hash2($n) {
        return sha1($n);
    }

    // преобразуем теги для хранения в базе
    static private function reformTagSql($tag) {
        if ($tag) {
            return is_string($tag) ? '[' . str_replace(',', '][', $tag) . ']' : implode(',', $tag);
        } else {
            return '';
        }
    }

    public function set($n, $v, $tags, $time) {
        //pre($n);
        $this->getResurse()->query("REPLACE INTO " . cDB::table('cache.data') . " SET `id`='" . $this->hash($n) . "', `name`='" . $this->hash2($n) . "', `time`='" . (time() + $time) . "', `tag`=" . $this->getResurse()->quote(self::reformTagSql($tags)) . ", `data`=" . $this->getResurse()->quote(serialize($v)));
    }

    public function get($n) {
        $res = $this->getResurse()->query("SELECT name, data FROM " . cDB::table('cache.data') . " WHERE `id`='" . $this->hash($n) . "' AND `time`>'" . time() . "'")
                ->fetchRowAll();
        if ($res) {
            $hash = $this->hash2($n);
            foreach ($res as $v) {
                if ($hash === $v[0]) {
                    return $v[1] ? unserialize($v[1]) : false;
                }
            }
        }
        return false;
    }

    public function delete($n) {
        $this->getResurse()->query("DELETE FROM " . cDB::table('cache.data') . " WHERE `id`='" . $this->hash($n) . "' AND `name`='" . $this->hash2($hash) . "'");
    }

    public function deleteTime() {
        $this->getResurse()->query("DELETE FROM " . cDB::table('cache.data') . " WHERE `time`<'" . time() . "'");
    }

    public function deleteTag($n) {
        $where = '';
        foreach (explode(',', $n) as $k) {
            $where .= ($where ? ' OR ' : '') . "`tag` LIKE " . $this->getResurse()->quote("%[{$k}]%") . "";
        }
        $this->getResurse()->query("DELETE FROM " . cDB::table('cache.data') . " WHERE " . $where);
    }

    public function clear() {
        $this->getResurse()->query("TRUNCATE TABLE " . cDB::table('cache.data'));
    }

}

