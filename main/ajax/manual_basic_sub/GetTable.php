<?php
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$manual_id = $_POST['manual_id'];

$sql = "SELECT * FROM tbl_manual_basic_sub WHERE manual_id = '$manual_id' and active_status = 1 ORDER BY list_order ASC";
$result = mysqli_query($connect_db, $sql); {

    $temp_array = array(
        "manual_sub_id" => $row['manual_sub_id'],
        "manual_sub_name" => $row['manual_sub_name'],
        "active_status" => $row['active_status'],
        "file_name" => $row['file_name'],
        "remark" => $row['remark']
    );

    array_push($list, $temp_array);
}
?>

<table id="table_manual" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:40%;">หัวข้อ</th>
            <th style="width:40%;">หมายเหตุ</th>
            <th style="width:40%;">ไฟล์</th>
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

                <td><?php echo $row['manual_sub_name']; ?></td>

                <td><?php echo $row['remark']; ?></td>

                <td>
                    <?php if ($row['file_name'] != "") {
                        ?>
                        <a target="_blank"
                            href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row['file_name']; ?>"
                            class='btn btn-xs'><button class='btn btn-xs btn-primary'><i class='fa fa-file'></i></button></a>
                    <?php } ?>
                </td>

                <td>
                    <button class="btn btn-xs btn-primary btn-block"
                        onclick="ModalAddbroken('<?php echo $row['manual_sub_id'] ?>');">เพิ่มอะไหล่</button>

                        <!-- <a href="spare_broken.php?id=<?php echo $row['manual_sub_id'] ?>&manual_id=<?php echo $manual_id ?>" class="btn btn-xs btn-success btn-block">รายละเอียด</a> -->
                        <button class="btn btn-xs btn-success btn-block" onclick="Modal_Detail('<?php echo $row['manual_sub_id'] ?>')">รายละเอียด</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>