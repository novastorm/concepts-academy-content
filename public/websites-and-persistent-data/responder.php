<?php
namespace Websites_And_Persistent_Data;

require 'Config.php';
require 'Database.php';
require 'Create_Todo.php';
// require Todo Model implementation;
require 'Todo_Model.php';
// require Todo View implementation;
require 'Todo_View.php';


use PDOException;

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

// TODO: Create todo model instance
$todo_model = new Todo_Model(
      Config::Table_Prefix
    , $dbh
    );
// TODO: Create todo view instance
$todo_view = new Todo_View($todo_model);

function create_tables ($tables)
{
    foreach ($tables as $table) {
        $table->create();
    }
}

// TODO: Todo model tests
function test ($todo_model)
{
    print "Index:\n";
    print json_encode($todo_model->index()) . "\n";

    print "Store: ";
    print json_encode($todo_model->store("Task 1")) . "\n";
    print json_encode($todo_model->index()) . "\n";
    $record_id = $todo_model->index()[0]['todo_id'];

    print "Show: ";
    $record = $todo_model->show($record_id);
    print json_encode($record) . "\n";

    print "Update: ";
    print json_encode($todo_model->update($record['todo_id'], "Task A")) . "\n";
    print json_encode($todo_model->index()) . "\n";

    print "Destroy: ";
    print json_encode($todo_model->destroy($record['todo_id'])) . "\n";
    print json_encode($todo_model->index()) . "\n";
}
// TODO: Create layout view
function layout_view ($body)
{
    $output = <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://192.168.33.10/content/websites-and-persistent-data/">
</head>
<body>
$body
</body>
</html>
EOF;
    return $output;
}
// TODO: Process routes
function process_route ($todo_view)
{
    $route = $_SERVER['PATH_INFO'];
    $result;

    if (preg_match('|^/todo/show/(\d+)$|', $route, $matches)) {
        $todo_id = $matches[1];
        $result = $todo_view->show($todo_id);
    }
    else if (preg_match('|^/todo/store$|', $route)) {
        $task = $_REQUEST['input-task'];
        $result = $todo_view->store(['task' => $task]);
        header("Location: ../todo");
    }
    else if (preg_match('|^/todo/update/(\d+)$|', $route, $matches)) {
        $todo_id = $matches[1];
        $task = $_REQUEST['input-task'];
        $result = $todo_view->update($todo_id, ['task' => $task]);
        header("Location: ../todo");
    }
    else if (preg_match('|^/todo/destroy/(\d+)$|', $route, $matches)) {
        $todo_id = $matches[1];
        $result = $todo_view->destroy($todo_id);
        header("Location: ../todo");
    }
    else if (preg_match('|^/todo/create$|', $route)) {
        $result = $todo_view->create();
    }
    else if (preg_match('|^/todo/show/(\d+)/edit$|', $route, $matches)) {
        $todo_id = $matches[1];
        $result = $todo_view->edit($todo_id);
    }
    // else if (preg_match('^/todo$', $route) {
    else {
        $result = $todo_view->index();
    }

    return layout_view($result);
}

try {
    // print "Create Tables\n";
    create_tables([$todo_table]);
    // TODO: run todo model tests
    // test ($todo_model);
    // TODO: run application routes
    print process_route($todo_view);
}
catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
?>