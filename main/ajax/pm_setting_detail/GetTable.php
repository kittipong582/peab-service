<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$pm_setting_id = mysqli_escape_string($connect_db, $_POST["pm_setting_id"]);

$sql_detail = "SELECT * FROM tbl_pm_setting_detail a WHERE a.pm_setting_id = '$pm_setting_id'";
$res_detail = mysqli_query($connect_db, $sql_detail);


// echo"$sql_detail";
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th>รายละเอียด</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row_detail = mysqli_fetch_assoc($res_detail)) { ?>
            <tr>
          
                <td>
                    <?php echo $row_detail['list_order']; ?>
                </td>
                <td>
                    <?php echo $row_detail['detail']; ?>
                </td>
                <td>
                    <button class="btn btn-xs btn-warning btn-block" type="button"
                        onclick="ModalEdit('<?php echo $row_detail['pm_setting_detail_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                    <button type="button" class="btn btn-xs btn-danger btn-block"
                        onclick="Delete_Detail('<?php echo $row_detail['pm_setting_detail_id']; ?>')">ลบ</button>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {

    });
    $('#summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

</script>