<?php
namespace Websites_And_Persistent_Data;

include 'Config.php';
include 'Database.php';
include 'Todo.php';

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

try {
	print "Create: ";
	print $todo->create() . "\n";
	print json_encode($todo->index()) . "\n";

	print "Store: ";
	print json_encode($todo->store("Task 1")) . "\n";
	print json_encode($todo->index()) . "\n";
	$record = $todo->show(1);
	print json_encode($record) . "\n";

	print "Update: ";
	print json_encode($todo->update($record['todo_id'], "Task A")) . "\n";
	print json_encode($todo->index()) . "\n";

	print "DELETE: ";
	print json_encode($todo->delete($record['todo_id'])) . "\n";
	print json_encode($todo->index()) . "\n";
}
catch (\PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}

?>