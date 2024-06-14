<?php
session_start();
require("../config/main_function.php");

$id = $_POST['id'];
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);



if ($connection) {

	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	$sql_check = "SELECT count(user_id) AS num FROM tbl_user WHERE user_id = '$id'";
	$rs_check = mysqli_query($connection, $sql_check) or die($connection->error);
	$row_check = mysqli_fetch_array($rs_check);

	if ($row_check['num'] > 0) {

		$sql = "SELECT * FROM tbl_user WHERE
		username = '$username' AND active_status = '1'";
		$rs = mysqli_query($connection, $sql) or die($connection->error);
		$row = mysqli_fetch_array($rs);

		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['fullname'] = $row['fullname'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['admin_status'] = $row['admin_status'];
		$_SESSION['user_level'] = $row['user_level'];
		$_SESSION['branch_id'] = $row['branch_id'];

		$result = 1;
		$id = $row['user_id'];
	} else if (strlen($username) > 0 && strlen($password) > 0) {

		$sql = "SELECT * FROM tbl_user WHERE
		username = '$username' AND active_status = '1'";
		$rs = mysqli_query($connection, $sql) or die($connection->error);
		$check = mysqli_num_rows($rs);
		if ($check == 1) {
			$row = mysqli_fetch_array($rs);
			$password = md5($password);

			/*  1  secure_text , secure_pointer  */
			$secure_text = $row['secure_text'];
			$secure_pointer = $row['secure_pointer'];
			$mypassword = stringInsert($password, $secure_text, $secure_pointer);

			if ($mypassword == $row['password']) {   // Login สำเร็จ //
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['fullname'] = $row['f_name'] . " " . $row['s_name'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['branch_id'] = $row['branch_id'];
				$_SESSION['admin_status'] = $row['admin_status'];
				$_SESSION['user_level'] = $row['user_level'];
				$_SESSION['audit_status'] = $row['audit_status'];


				$id = $row['user_id'];


				// if ($row['admin_status'] == 8262) {
				// 	$result = 2;
				// } else {
				// 	$result = 1;
				// }

				$result = 1;

			} else {  // รหัสผ่านไม่ถูกต้อง //

				$result = 0;
			}
		} else { //user หรือ สิทิ์ไม่ถูก
			$result = 0;
		}
	} else { // input null value

		$result = 0;
	}
} else {

	$result = 0;
}

$arr['result'] = $result;
$arr['id'] = $id;
echo json_encode($arr);
