 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $checklist_id =  mysqli_real_escape_string($connection, $_POST['checklist_id']);

    if($connection){

    $sql_delete = "DELETE FROM tbl_qc_checklist WHERE checklist_id  = '$checklist_id'";

    $res_delete = mysqli_query($connection, $sql_delete)  or die($connection->error);

        if($res_delete){
            $arr['result'] = 1;
        }else{
            $arr['result'] = 0;
        }
    }else{
    $arr['result'] = 9;
    }

mysqli_close($connection);
echo json_encode($arr);
?>