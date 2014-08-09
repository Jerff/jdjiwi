<?php

class cDatabaseUtility {

    // количество рядов
    public function getFoundRows() {
        return (int) cDB::query('SELECT FOUND_ROWS()')->fetchRow(0);
    }

    // список все таблиц базы
    public function tableList() {
        return cDB::query("SHOW TABLES")->fetchRowAll();
    }

}
