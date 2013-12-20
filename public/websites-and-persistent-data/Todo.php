<?php
namespace Websites_And_Persistent_Data;

class Todo {
    private static $table_name = 'todo';

    private $table_prefix;
    private $dbh;

    public function __construct ($prefix, $dbh) {
        $this->table_prefix = $prefix;
        $this->dbh = $dbh;
    }

    public function create () {
        $table = $this->table_prefix . self::$table_name;

        $sth = $this->dbh->prepare("
            CREATE TABLE IF NOT EXISTS $table (
                  todo_id INTEGER PRIMARY KEY AUTO_INCREMENT
                , task TEXT
                , completed INTEGER DEFAULT 0
            )");

        if (!$sth) {
            die("Error: " . $this->dbh->error . "\n");
        }

        $ok = $sth->execute();

        if (! $ok) {
            die("Error: " . $this->dbh->error . "\n");
        }
    }

    public function index () {
        $table = $this->table_prefix . self::$table_name;

        $sth = $this->dbh->prepare("
            SELECT * FROM $table;
            ");

        if (!$sth) {
            die("Error: " . $this->dbh->error . "\n");
        }

        $ok = $sth->execute();

        if (! $ok) {
            die("Error: " . $this->dbh->error . "\n");
        }
    }
}
?>
