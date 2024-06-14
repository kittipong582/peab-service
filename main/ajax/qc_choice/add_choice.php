 <?php
    session_start();
    include("../../../config/main_function.php");
    $connection = connectDB("LM=VjfQ{6rsm&/h`");

    $choicelist_id  = getRandomID2(10, 'tbl_qc_choicelist', 'choicelist_id');
    $checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
    $choice_detail = mysqli_real_escape_string($connection, $_POST['choice_detail']);

    //$list_order = list_order("tbl_qc_choicelist", "list_order");

    $sql ="SELECT MAX(list_order) AS NextList FROM tbl_qc_choicelist WHERE checklist_id = '$checklist_id'";
	$rs = mysqli_query($connection, $sql);
	$row = mysqli_fetch_assoc($rs);
	$list_order = $row['NextList'] + 1;

    if ($connection) {

        $sql_insert = "INSERT INTO tbl_qc_choicelist SET  
        choicelist_id = '$choicelist_id',
        checklist_id = '$checklist_id',
        choice_detail = '$choice_detail',
        list_order = '$list_order'";

        $res_insert = mysqli_query($connection, $sql_insert)  or die($connection->error);

        if ($res_insert) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 9;
    }

    mysqli_close($connection);
    echo json_encode($arr);
    ?>