

<?php

require("../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql_customer = "SELECT signature_image FROM tbl_job
WHERE signature_image IS NOT NULL";
$rs_customer = mysqli_query($connect_db, $sql_customer) or die($connect_db->error);
$row_customer = mysqli_fetch_assoc($rs_customer);



$imageData = $row_customer['signature_image'];


// A few settings
$img_file = $imageData;

// Read image path, convert to base64 encoding
$imgData = base64_encode(file_get_contents($img_file));

// Format the image SRC:  data:{mime};base64,{data};
$src = 'data: ' . mime_content_type($img_file) . ';base64,' . $imgData;



