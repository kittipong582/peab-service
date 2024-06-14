<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$brand_id = $_POST['brand_id'];

$sql = "SELECT * FROM tbl_manual WHERE active_status = 1 ";
$result  = mysqli_query($connect_db, $sql); {

    $temp_array = array(
        "manual_id" => $row['manual_id'],
        "manual_name" => $row['manual_name'],
        "active_status" => $row['active_status'],
        "file_name" => $row['file_name'],
        "remark" => $row['remark']
    );

    array_push($list, $temp_array);
}
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:40%;">หัวข้อ</th>
            <th style="width:40%;">หมายเหตุ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>

                <td><?php echo $row['manual_name']; ?></td>

                <td><?php echo $row['remark']; ?></td>

                <td>
                    <div class='form-group'>
                        <a href='manual_sub_list.php?id=<?php echo $row['manual_id']; ?>'><button class="btn btn-xs btn-success btn-block" type="button">
                                รายการย่อย
                            </button></a>
                    </div>
                    <button class="btn btn-xs btn-warning btn-block mb-3" type="button" onclick="ModalEdit('<?php echo $row['manual_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                        <button class="btn btn-xs btn-danger btn-block" type="button" onclick="Delete('<?php echo $row['manual_id']; ?>')">
                        ลบ
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>