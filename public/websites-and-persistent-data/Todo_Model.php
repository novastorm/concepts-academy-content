<?php
namespace Websites_And_Persistent_Data;

use PDO;

class Todo_Model {
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

    // TODO: Todo index
    public function index () {
        $table = $this->table();

        $query = "
            SELECT * FROM $table
            ";

        $sth = $this->_dbh->prepare($query);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    // TODO: Todo show
    public function show ($id) {
        if (! is_numeric($id)) {
            return false;
        }

        $table = $this->table();
        $primary_key = self::$_primary_key;

        $query = "
            SELECT * FROM $table
            WHERE $primary_key = :todo_id
            ";

        $sth = $this->_dbh->prepare($query);
        $sth->bindParam(':todo_id', $id, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    // TODO: Todo store
    public function store ($task) {
        $table = $this->table();
        $primary_key = self::$_primary_key;

        $query = "
            INSERT INTO $table(task)
            VALUES (:task)
            ";

        $sth = $this->_dbh->prepare($query);
        $sth->bindParam(':task', $task, PDO::PARAM_STR);
        $sth->execute();

        return true;
    }
    // TODO: Todo update
    // TODO: Todo update
    public function update ($id, $task) {
        if (! is_numeric($id)) {
            return false;
        }
        $table = $this->table();
        $primary_key = self::$_primary_key;

        $query = "
            UPDATE $table
            SET task = :task
            WHERE $primary_key = :todo_id
            ";

        $sth = $this->_dbh->prepare($query);
        $sth->bindParam(':todo_id', $id, PDO::PARAM_INT);
        $sth->bindParam(':task', $task, PDO::PARAM_STR);
        $sth->execute();

        return true;
    }
    // TODO: Todo destroy
    public function destroy ($id) {
        if (! is_numeric($id)) {
            return false;
        }
        $table = $this->table();
        $primary_key = self::$_primary_key;

        $query = "
            DELETE FROM $table
            WHERE $primary_key = :todo_id
            ";

        $sth = $this->_dbh->prepare($query);
        $sth->bindParam(':todo_id', $id, PDO::PARAM_INT);
        $sth->execute();

        return true;
    }
}
?>
