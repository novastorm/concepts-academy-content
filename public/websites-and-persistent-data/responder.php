<?php
namespace Websites_And_Persistent_Data;

require 'Config.php';
require 'Database.php';
require 'Create_Todo.php';
require 'Todo_Model.php';
require 'Todo_View.php';

$dbh = Database::initialize(
      Config::Database_Engine
    , Config::Hostname
    , Config::Username
    , Config::Password
    , Config::Database
    );

$todo_table = new Create_Todo(
      Config::Table_Prefix
    , $dbh
    );


$todo_model = new Todo_Model(
      Config::Table_Prefix
    , $dbh
    );

function create_tables ($tables)
{
    foreach ($tables as $table) {
        \var_dump($table);
        $table->create();
    }
}

function test ($todo_model)
{
    try {
        print "Create: ";
        print $todo_model->create() . "\n";

        print "Index:\n";
        print json_encode($todo_model->index()) . "\n";

        print "Store: ";
        print json_encode($todo_model->store("Task 1")) . "\n";
        print json_encode($todo_model->index()) . "\n";
        $record_id = $todo_model->index()[0]['todo_model_id'];

        print "Show: ";
        $record = $todo_model->show($record_id);
        print json_encode($record) . "\n";

        print "Update: ";
        print json_encode($todo_model->update($record['todo_model_id'], "Task A")) . "\n";
        print json_encode($todo_model->index()) . "\n";

        print "Destroy: ";
        print json_encode($todo_model->destroy($record['todo_model_id'])) . "\n";
        print json_encode($todo_model->index()) . "\n";
    }
    catch (\PDOException $e) {
        die("Error: " . $e->getMessage() . "\n");
    }
}

create_tables([$todo_table]);
test ($todo_model);
?>
