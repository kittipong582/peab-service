<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 1; URL=$url1");
$sql = "DELETE FROM `tbl_job` WHERE `contact_name` = 'tao'";
$res = mysqli_query($connect_db, $sql);
