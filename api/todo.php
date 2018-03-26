<?php 
	include '../connection/conn.php'; 
	$method = $_SERVER['REQUEST_METHOD'];
	$input = json_decode(file_get_contents('php://input'),true);

	switch ($method) {
	  case 'GET':
	  	$has_id = '';
		if ($_GET['id'] > 0){
			$sql = "select id, is_completed, title from todo_notes where is_active = 1 and type = 'todo' and id = '".$_GET['id']."' order by is_completed"; 
		}else{
			$sql = "select id, is_completed, title from todo_notes where is_active = 1 and type = 'todo' order by is_completed"; 
		}

		break;
	    
	  case 'PUT':

	  	if (isset($input['title'])){
	  		$sql = "update todo_notes set title = '".$input['title']."' where id = '".$input['id']."'"; 
	  	}else if (isset($input['type'])){
	  		$sql = "update todo_notes set type = '".$input['type']."' where id = '".$input['id']."'"; 
	  	}else if (isset($input['deleted'])){
	  		$sql = "update todo_notes set is_deleted = 1,is_active = 0,  date_time_deleted = now() where id = '".$input['id']."'"; 
	  	}else{
	  		if ($input['status'] == 1){
	  			$sql = "update todo_notes set is_completed = 0 where id = '".$input['id']."'"; 
	  		}else{
	  			$sql = "update todo_notes set is_completed = 1, date_time_completed = now() where id = '".$input['id']."'";
	  		}
	  	}
	  	 break;
	    
	  case 'POST':
	    $sql = "insert into todo_notes(type, title, is_active, date_time_added, is_deleted, is_completed) values
	    ('todo','".$input['title']."',1, now(), 0, 0)"; break;
	}

	// excecute SQL statement
	$result = mysqli_query($link,$sql);
	 
	// die if SQL statement failed
	if (!$result) {
	  http_response_code(300);
	  die($link->connect_error);
	}
	 
	// print results, insert id or affected row count
	if ($method == 'GET') {
	  echo json_encode(mysqli_fetch_all($result,MYSQLI_ASSOC));
	} elseif ($method == 'POST') {
	  echo mysqli_insert_id($link);
	} else {
	  echo mysqli_affected_rows($link);
	}
	
	// close mysql connection
	mysqli_close($link);
 
?>