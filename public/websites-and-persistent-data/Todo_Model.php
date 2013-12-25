<?php
namespace Websites_And_Persistent_Data;

class Todo_Model {
    private static $table_name = 'todo';
    private static $primary_key = 'todo_id';

    private $table_prefix;
    private $dbh;

    public function __construct ($prefix, $dbh) {
        $this->table_prefix = $prefix;
        $this->dbh = $dbh;
    }

    public function index () {
        $table = $this->table_prefix . self::$table_name;

        $query = "
            SELECT * FROM $table
            ";

        $sth = $this->dbh->prepare($query);
        $sth->execute();

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function show ($id) {
        if (! is_numeric($id)) {
            return false;
        }

        $table = $this->table_prefix . self::$table_name;
        $primary_key = self::$primary_key;

        $query = "
            SELECT * FROM $table
            WHERE $primary_key = :todo_id
            ";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':todo_id', $id, \PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function store ($task) {
        $table = $this->table_prefix . self::$table_name;
        $primary_key = self::$primary_key;

        $query = "
            INSERT INTO $table(task)
            VALUES (:task)
            ";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':task', $task, \PDO::PARAM_STR);
        $sth->execute();

        return true;
    }

    public function update ($id, $task) {
        if (! is_numeric($id)) {
            return false;
        }
        $table = $this->table_prefix . self::$table_name;
        $primary_key = self::$primary_key;

        $query = "
            UPDATE $table
            SET task = :task
            WHERE $primary_key = :todo_id
            ";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':todo_id', $id, \PDO::PARAM_INT);
        $sth->bindParam(':task', $task, \PDO::PARAM_STR);
        $sth->execute();

        return true;
    }

    public function destroy ($id) {
        if (! is_numeric($id)) {
            return false;
        }
        $table = $this->table_prefix . self::$table_name;
        $primary_key = self::$primary_key;

        $query = "
            DELETE FROM $table
            WHERE $primary_key = :todo_id
            ";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':todo_id', $id, \PDO::PARAM_INT);
        $sth->execute();

        return true;
    }
}
?>
