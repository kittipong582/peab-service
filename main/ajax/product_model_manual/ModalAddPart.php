<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$model_id = mysqli_real_escape_string($connect_db, $_POST['model_id']);

$sql_part_type = "SELECT * FROM tbl_spare_type ";
$res_part_type = mysqli_query($connect_db, $sql_part_type);


?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่ม อะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="model_id" name="model_id" value="<?php echo $model_id; ?>">

            <div class="col-12 mb-2">
                <label for="">ประเภท : </label>
                <select name="spare_type" id="spare_type" class="form-select" style="width: 100%;" onchange="GetSpareType();">
                    <?php while ($row_part_type = mysqli_fetch_assoc($res_part_type)) { ?>
                        <option value="<?php echo $row_part_type['spare_type_id']; ?>"><?php echo $row_part_type['spare_type_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 mb-2" id="part_div">

            </div>

        </div>

    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="AddSparePart();">บันทึก</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".form-select").select2();
    });

    function GetSpareType() {

        let spare_type = $('#spare_type').val();
        $.ajax({
            type: "POST",
            url: "ajax/product_model_manual/GetSparepPartType.php",
            data: {
                spare_type: spare_type
            },
            dataType: "html",
            success: function(response) {
                $('#part_div').html(response);
                $(".form-select").select2();
            }
        });
    }

   
</script>