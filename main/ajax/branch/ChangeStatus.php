<?php
	include('../../../config/main_function.php');
	$secure = "LM=VjfQ{6rsm&/h`";
	$connection = connectDB($secure);

	$branch_id = $_POST['branch_id'];


	$sql = "SELECT active_status FROM tbl_branch WHERE branch_id = '$branch_id';";
	$rs = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($rs);

	if($row['active_status'] == "1"){

		$new_status = "0";
	}
	else{

		$new_status = "1";
	}

	$sql = "UPDATE tbl_branch SET active_status = '$new_status' WHERE branch_id = '$branch_id';";
	$rs = mysqli_query($connection,$sql);

	$arr['result'] = 1;

	echo json_encode($arr);
?>

