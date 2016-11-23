<?php

namespace Jdjiwi;

class Settings {

    private static $value = array();

    private static function start() {
        static $is = false;
        if ($is) {
            return;
        }
        $is = true;
        self::$value = Cache::run(array(__CLASS__, __FUNCTION__), function() {
                    $res = cDB::sql()->placeholder("SELECT id, data FROM ?t WHERE cache='yes' AND data!=''", cDB::table('sys.settings'))
                            ->fetchAssocAll();
                    $value = array();
                    foreach ($res as $row) {
                        $value[$row['id']] = unserialize($row['data']);
                    }
                    return $value;
                });
        self::$value = $value;
    }

    public static function get($part, $id = null) {
        self::start();
        return $id ? get2(self::$value, $part, $id) : get(self::$value, $part);
    }

    public static function read($part, $id = null) {
        $data = cDB::sql()->placeholder("SELECT data FROM ?t WHERE id=?", cDB::table('sys.settings'), $part)
                ->fetchRow(0);
        if (!$data)
            return $data;
        $data = unserialize($data);
        if (!$id)
            return $data;
        return get($data, $id);
    }

    public static function save($part, $send) {
        $data = cDB::sql()->placeholder("SELECT data FROM ?t WHERE id=?", cDB::table('sys.settings'), $part)
                ->fetchRow(0);
        if ($data) {
            $data = unserialize($data);
            foreach ($send as $k => $v)
                $data[$k] = $v;
            $send = $data;
        }
        cDB::sql()->add(cDB::table('sys.settings'), array('data' => serialize($send)), $part);
    }

}
