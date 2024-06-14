<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$expend_type_id = $_POST['expend_id'];
$sql = "SELECT * FROM tbl_expend_type WHERE expend_type_id = '$expend_type_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>


<label></label><br>
<label style="padding-top: 5px;"><?php echo $row['description'] ?></label>