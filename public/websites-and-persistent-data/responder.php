<?php
namespace Websites_And_Persistent_Data;

include 'Config.php';
include 'Database.php';
include 'Todo.php';

$dbh = Database::initialize(
      Config::Hostname
    , Config::Username
    , Config::Password
    , Config::Database
    );

$todo = new Todo(
      Config::Table_Prefix
    , $dbh
    );

$todo->create();
print json_encode($todo->index());

?>