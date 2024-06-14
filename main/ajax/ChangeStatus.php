<?php
	include('../../config/main_function.php');
	$secure = "LM=VjfQ{6rsm&/h`";
	$connection = connectDB($secure);

	$key_value = $_POST['key_value'];
	$table_name = $_POST['table_name'];
	$key_name = $_POST['key_name'];

	$sql = "SELECT active_status FROM $table_name WHERE $key_name = '$key_value';";
	$rs = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($rs);

	if($row['active_status'] == "1"){

		$new_status = "0";
	}
	else{

		$new_status = "1";
	}

	$sql = "UPDATE $table_name SET active_status = '$new_status' WHERE $key_name = '$key_value';";
	$rs = mysqli_query($connection,$sql);

	$arr['result'] = 1;

	echo json_encode($arr);
?>

