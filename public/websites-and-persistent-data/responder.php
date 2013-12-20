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
	print $todo->create() . "\n";
	print json_encode($todo->index()) . "\n";
	print json_encode($todo->show(1)) . "\n";
}
catch (\PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}

?>