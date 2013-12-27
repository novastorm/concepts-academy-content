<?php
namespace Websites_And_Persistent_Data;

require 'Todo_Model.php';

class Todo_View {
	private $_model;

	public function __construct ($model)
	{
		$this->_model = $model;
	}

	public function index ()
	{
		$record_list = $this->_model->index();
		$output = json_encode($record_list);
		return $output;
	}

	public function show ($id)
	{
		$record = $this->_model->show($id);
		$output = json_encode($record);
		return $output;
	}

	public function store ($param)
	{
		$record = $this->_model->store($param['task']);
		$output = json_encode($record);
		return $output;
	}

	public function update ($id, $param)
	{
		$record = $this->_model->update($id, $param['task']);
		$output = json_encode($record);
		return $output;
	}

	public function destroy ($id)
	{
		$record = $this->_model->destroy($id);
		$output = json_encode($record);
		return $output;
	}

	public function create ()
	{
		$output = "Create View";
		$output = <<< EOF
<form action="response.php/todo/store">
	<label for="input-task">Task</label>
	<input type="text" name="input-task" placeholder="Task">
	<button type="submit">Add Task</button>
</form>
EOF;
		return $output;
	}

	public function edit ()
	{
		$output = "Edit View";
		return $output;
	}
}

?>
