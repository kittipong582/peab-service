<?php
include ("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$group_id = mysqli_real_escape_string($connect_db, $_POST['group_id']);
$job_id = mysqli_real_escape_string($connect_db, $_POST['job_id']);


// $sql_audit_id = "SELECT a.* , b.signature_image FROM tbl_job_audit a JOIN tbl_job_audit_group b ON a.group_id = b.group_id WHERE a.group_id = '$group_id'";
// $res_audit_id = mysqli_query($connect_db, $sql_audit_id);
// $row_audit_id = mysqli_fetch_assoc($res_audit_id);

$sql_sum_score = "SELECT SUM(score) AS score FROM tbl_audit_record WHERE job_id ='$job_id' ";
$res_sum_score = mysqli_query($connect_db, $sql_sum_score);
$row_sum_score = mysqli_fetch_assoc($res_sum_score);


?>
<div id="score_point">
    คะแนนรวม :
    <?php echo $row_sum_score['score']; ?> คะแนน
</div>