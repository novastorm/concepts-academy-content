<?php
namespace Websites_And_Persistent_Data;

class Todo_View {
    private $_model;

    public function __construct ($model)
    {
        $this->_model = $model;
    }

    // TODO: Todo view index
    public function index ()
    {
        $record_list = $this->_model->index();
        // $output = json_encode($record_list);
        $output = "";
        $output .= <<<EOF
<h2>Todo List <a href="responder.php/todo/create"><button>New</button></a></h2>
EOF;
        $output .= "<table>\n";

        foreach ($record_list as $record) {
            $todo_id = $record['todo_id'];
            $task = $record['task'];

            $output .= <<<EOF
<tr>
    <td><a href="responder.php/todo/show/$todo_id">$task</a></td>
    <td><a href="responder.php/todo/show/$todo_id/edit">edit</a></td>
    <td><a href="responder.php/todo/destroy/$todo_id">destroy</a></td>
</tr>
EOF;
        }

        $output .= "\n</table>\n";
        return $output;
    }
    // TODO: Todo view show
    public function show ($id)
    {
        $record = $this->_model->show($id);

        $todo_id = $record['todo_id'];
        $task = $record['task'];

        $output = <<<EOF
<dl>
    <dt>ID:</dt>
    <dd>$todo_id</dd>
    <dt>Task:</dt>
    <dd>$task</dd>
</dl>
EOF;
        return $output;
    }
    // TODO: Todo view store
    public function store ($param)
    {
        return $this->_model->store($param['task']);
    }
    // TODO: Todo view update
    public function update ($id, $param)
    {
        return $this->_model->update($id, $param['task']);
    }
    // TODO: Todo view destroy
    public function destroy ($id)
    {
        return $this->_model->destroy($id);
    }
    // TODO: Todo view create
    public function create ()
    {
        $output = <<< EOF
<form action="responder.php/todo/store">
    <label for="input-task">Task</label>
    <input type="text" name="input-task" placeholder="Task">
    <button type="submit">Add Task</button>
</form>
EOF;
        return $output;
    }
    // TODO: Todo view edit
    public function edit ($id)
    {
        $record = $this->_model->show($id);

        $todo_id = $record['todo_id'];
        $task = $record['task'];

        $output = <<< EOF
<form action="responder.php/todo/update/$todo_id">
    <label for="input-task">Task</label>
    <input type="text" name="input-task" value="$task" placeholder="Task">
    <button type="submit">Update Task</button>
</form>
EOF;
        return $output;
    }
}
?>