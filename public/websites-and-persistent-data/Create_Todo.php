<?php
namespace Websites_And_Persistent_Data;

class Create_Todo {
    private static $_table_name = 'todo';
    private static $_primary_key = 'todo_id';

    private $_table_prefix;
    private $_dbh;

    public function __construct ($prefix, $dbh) {
        $this->_table_prefix = $prefix;
        $this->_dbh = $dbh;
    }

    protected function table () {
        return $this->_table_prefix . self::$_table_name;
    }

    public function create () {
        $table = $this->table();

        $query = "
            CREATE TABLE IF NOT EXISTS $table (
                  todo_id INTEGER PRIMARY KEY AUTO_INCREMENT
                , task TEXT
                , completed INTEGER DEFAULT 0
            )
            ";

        $sth = $this->_dbh->prepare($query);
        $sth->execute();

        return true;
    }
}
?>
