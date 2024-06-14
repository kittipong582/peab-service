<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$branch_id = $_POST['branch'];
$serial_no = $_POST['serial_search'];


$job_type = $_POST['job_type'];


    $sql = "SELECT * FROM tbl_job_evaluate WHERE job_type = '$job_type'";
    $result  = mysqli_query($connect_db, $sql);

// echo $sql;
?>

<table class="table table-striped table-bordered table-hover" id="tbl_evaluate">
    <thead>
        <tr>
            <th style="width:10%;">ข้อ</th>
            <th class="text-left">ข้อความ</th>
            <!-- <th class="text-center">ประเภท</th>
            <th class="text-center">ตัวเลือก</th> -->

            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody id="sortable">
        <?php
        $i = 0;

        // echo $sql;
        while ($row = mysqli_fetch_array($result)) {
        ?>
        <tr id="tr_<?php echo $row['evaluate_id'] ?>">
            <td class="list_order"><?php echo $row['list_order']; ?></td>
            <td class="text-left"><?php echo $row['detail']; ?></td>
            <!-- <td class="text-center"><?php echo $form_type . " " . $remark; ?></td>
            <td class="text-center"><?php echo $row['choice1'] . '/' . $row['choice2'] ?></td> -->

            <td>
                <button class="btn btn-xs btn-warning btn-block"
                    onclick="ModalEdit('<?php echo $row['evaluate_id'] ?>');">แก้ไข</button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>