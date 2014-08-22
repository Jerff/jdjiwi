<?php

abstract class cDatabaseUtility {

    // количество рядов
    abstract public function getFoundRows();

    // список все таблиц базы
    public function tableList() {
        return cDB::query("SHOW TABLES")->fetchRowAll();
    }

}
