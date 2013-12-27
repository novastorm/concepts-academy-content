<?php
namespace Websites_And_Persistent_Data;

require 'Config.php';
require 'Database.php';
require 'Create_Todo.php';
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


$todo_model = new Todo_Model(
      Config::Table_Prefix
    , $dbh
    );

$todo_view = new Todo_View($todo_model);

function create_tables ($tables)
{
    foreach ($tables as $table) {
        // print "Create: ";
        $table->create();
    }
}

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

function layout_view ($body)
{
    $output = <<<EOF
<!DOCTYPE html>
<html lang="en">
<body>
$body
</body>
</html>
EOF;
    return $output;
}

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
    }
    else if (preg_match('|^/todo/update/(\d+)$|', $route, $matches)) {
        $todo_id = $matches[1];
        $task = $_REQUEST['input-task'];
        $result = $todo_view->update($todo_id, ['task' => $task]);
    }
    else if (preg_match('|^/todo/destroy/(\d+)$|', $route, $matches)) {
        $todo_id = $matches[1];
        $result = $todo_view->destroy($todo_id);
    }
    else if (preg_match('|^/todo/create$|', $route)) {
        $result = $todo_view->create();
    }
    else if (preg_match('|^/todo/edit$|', $route)) {
        $result = $todo_view->edit();
    }
    // else if (preg_match('^/todo$', $route) {
    else {
        $result = $todo_view->index();
    }

    return layout_view($result);
}

try {
    create_tables([$todo_table]);
    // test ($todo_model);
    print process_route($todo_view);
}
catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}

?>
