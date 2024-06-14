<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$model_id = $_POST['model_id'];

$sql = "SELECT * FROM tbl_product_model_manual WHERE model_id='$model_id' ORDER BY list_order";
$result  = mysqli_query($connect_db, $sql); {

    $temp_array = array(
        "model_id" => $row['model_id'],
        "manaul_name" => $row['manaul_name'],
        "description" => $row['description'],
        "manual_image" => $row['manual_image'],
        "active_status" => $row['active_status'],
        "manual_id" => $row['manual_id'],

    );

    array_push($list, $temp_array);
}
?>

<table class="table table-striped table-bordered table-hover" id="table_manual">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:20%;">รูป</th>
            <th style="width:30%;">ชื่อ</th>
            <th style="width:30%;">รายละเอียด</th>
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

                <td>
                    <a target="_blank" href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row['manual_image']; ?>" data-lity>
                        <?php
                        $file_type = explode('.', $row['manual_image']);
                        if ($file_type[1] == 'pdf') {
                        ?>
                            <img class="mb-3" loading="lazy" id="blah" src="upload/pdf_icon.jpg" width="75px" height="75px" />
                        <?php } else { ?>
                            <img class="mb-3" loading="lazy" id="blah" src="<?php echo ($row['manual_image'] != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $row['manual_image'] : "upload/No-Image.png" ?>" width="75px" height="75px" />
                        <?php } ?>
                    </a>
                </td>
                <td><?php echo $row['manaul_name']; ?></td>

                <td><?php echo $row['description']; ?></td>

                <td>
                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['manual_id']; ?>',1)">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                    <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['manual_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                    <button class="btn btn-xs btn-danger btn-block" type="button" onclick="DeleteManual('<?php echo $row['manual_id']; ?>')">
                        ลบข้อมูล
                    </button>


                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>