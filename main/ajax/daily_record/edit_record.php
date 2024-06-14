<?php
    session_start();
    include("../../../config/main_function.php");
    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $record_text = mysqli_real_escape_string($connection, $_POST['record_text']);

    $daily_id = mysqli_real_escape_string($connection, $_POST['daily_id']);

    


        $sql = "UPDATE tbl_customer_daily_record
    SET  
        record_title = '$title'
        ,record_text = '$record_text'
        WHERE daily_id = '$daily_id'
     ;";

    $rs  = mysqli_query($connection, $sql) or die($connection->error);


    /////////////////////////////////////////////////

if ($_FILES['file_name'] != "") {


    $tmpFilePath_1 = $_FILES['file_name']['tmp_name'];

    $file_1 = explode(".", $_FILES['file_name']['name']);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;
    
    if ($file_surname_1 == 'pdf' || $file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'png' || $file_surname_1 == 'PDF' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1== 'PNG'
        || $file_surname_1 == 'xlsx' || $file_surname_1 == 'XLSX' || $file_surname_1 == 'xls' || $file_surname_1 == 'XLS' || $file_surname_1 == 'docx' || $file_surname_1 == 'doc' || $file_surname_1 == 'DOCX' || $file_surname_1 == 'DOC') {

        if (move_uploaded_file($_FILES['file_name']['tmp_name'],"../../upload/".$filename_images_1)) {
            
            $sql_img = "UPDATE tbl_customer_daily_record SET record_file = '$filename_images_1' WHERE daily_id = '$daily_id'";
            
            $rs_img = mysqli_query($connection, $sql_img) or die($connection->error);

           
        }
    
    }

    // $arr['result'] = 0;
}
/////////////////////////////////////////////////

    if($rs){
    $arr['result'] = 1;
    } else {
    $arr['result'] = 0;
    }

    echo json_encode($arr);
    mysqli_close($connection);
    

?>