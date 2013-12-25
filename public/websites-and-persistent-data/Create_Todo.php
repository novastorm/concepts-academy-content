<?php
namespace Websites_And_Persistent_Data;

class Create_Todo {
    private static $table_name = 'todo';
    private static $primary_key = 'todo_id';

    private $table_prefix;
    private $dbh;

    public function __construct ($prefix, $dbh) {
        $this->table_prefix = $prefix;
        $this->dbh = $dbh;
    }

    public function create () {
        $table = $this->table_prefix . self::$table_name;

        $query = "
            CREATE TABLE IF NOT EXISTS $table (
                  todo_id INTEGER PRIMARY KEY AUTO_INCREMENT
                , task TEXT
                , completed INTEGER DEFAULT 0
            )
            ";

        $sth = $this->dbh->prepare($query);
        $sth->execute();

        return true;
    }
}
?>
