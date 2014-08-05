<?php

class cLimit {

    static public function is($id, $limit) {
        return $limit > cDB::sql()->placeholder("SELECT count(`date`) FROM ?t WHERE id=? AND date>=?", cDB::table('sys.limit'), $id, date('Y-m-d H:i:s', time() - 60 * 60))
                        ->fetchRow(0);
    }

    static public function add($id) {
        cDB::sql()->add(cDB::table('sys.limit'), array('id' => $id, 'date' => date('Y-m-d H:i:s')));
    }

}
