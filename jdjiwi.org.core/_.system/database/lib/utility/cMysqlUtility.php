<?php

class cMysqlUtility extends cDatabaseUtility {

    // количество рядов
    public function getFoundRows() {
        return (int) cDB::query('SELECT FOUND_ROWS()')->fetchRow(0);
    }

}
