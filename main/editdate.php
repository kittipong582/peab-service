<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql = "SELECT * FROM tbl_group_pm WHERE group_date ='1970-01-01'";
// $res = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_assoc($res)) {

    echo $row['group_pm_id'];
    echo '<br>';
    echo $row['group_date'];
    echo '<br>';
    echo  $newdate = date("Y-m-d", strtotime($row['create_group_datetime']));
    echo '<br>';

    echo $sqlup = "UPDATE tbl_group_pm SET group_date ='$newdate' WHERE group_pm_id = '{$row['group_pm_id']}' AND group_date ='1970-01-01' ";
    // $resup = mysqli_query($connect_db, $sqlup);
    echo '<br>';

}
