<?php
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$model_id = $_POST['model_id'];

$sql = "SELECT * FROM tbl_manual_basic WHERE model_id = '$model_id'";
$res = mysqli_query($connect_db, $sql);


?>

<table class="table table-striped table-bordered table-hover" id="table_basic">
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
        while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
                <td><?php echo ++$i; ?></td>

                <td><?php echo $row['manual_name']; ?></td>

                <td><?php echo $row['remark']; ?></td>

                <td>
                    <div class='form-group'>
                        <a
                            href='manual_basic_sub.php?id=<?php echo $row['manual_id']; ?>&model_id=<?php echo $row['model_id']; ?>'><button
                                class="btn btn-xs btn-success btn-block" type="button">
                                รายการย่อย
                            </button></a>

                    </div>
                    <button class="btn btn-xs btn-warning btn-block mb-3" type="button"
                        onclick="ModalEdit_Manual('<?php echo $row['manual_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                    <button class="btn btn-xs btn-danger btn-block" type="button"
                        onclick="Delete_Manual('<?php echo $row['manual_id']; ?>')">
                        ลบ
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>