<?php
namespace Websites_And_Persistent_Data;

require 'Config.php';
require 'Database.php';
require 'Todo.php';

$dbh = Database::initialize(
      Config::Database_Engine
    , Config::Hostname
    , Config::Username
    , Config::Password
    , Config::Database
    );

$todo = new Todo(
      Config::Table_Prefix
    , $dbh
    );

function test ($todo) {
    try {
        print "Create: ";
        print $todo->create() . "\n";

        print "Index:\n";
        print json_encode($todo->index()) . "\n";

        print "Store: ";
        print json_encode($todo->store("Task 1")) . "\n";
        print json_encode($todo->index()) . "\n";
        $record_id = $todo->index()[0]['todo_id'];

        print "Show: ";
        $record = $todo->show($record_id);
        print json_encode($record) . "\n";

        print "Update: ";
        print json_encode($todo->update($record['todo_id'], "Task A")) . "\n";
        print json_encode($todo->index()) . "\n";

        print "Delete: ";
        print json_encode($todo->delete($record['todo_id'])) . "\n";
        print json_encode($todo->index()) . "\n";
    }
    catch (\PDOException $e) {
        die("Error: " . $e->getMessage() . "\n");
    }
}

test ($todo);
?>
