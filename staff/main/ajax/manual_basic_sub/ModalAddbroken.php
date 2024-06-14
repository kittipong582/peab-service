<?php

include ("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

// $manual_id = $_GET['manual_id'];

$manual_id = $_POST['manual_id'];
$manual_sub_id = $_POST['manual_sub_id'];
$model_id = $_POST['model_id'];
$spare_broken_id = getRandomID2(10, 'tbl_spare_broken', 'spare_broken_id');

$list = array();

$sql = "SELECT * FROM tbl_spare_type";
$result = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "spare_type_id" => $row['spare_type_id'],
        "spare_type_name" => $row['spare_type_name'],
        "active_status" => $row['active_status'],
    );

    array_push($list, $temp_array);

}
?>


<form action="" method="post" id="form-add-broken" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" class="form-control mb-3" id="manual_id" name="manual_id"
                value="<?php echo $manual_id; ?>">

            <input type="hidden" class="form-control mb-3" id="manual_sub_id" name="manual_sub_id"
                value="<?php echo $manual_sub_id; ?>">

            <input type="hidden" class="form-control mb-3" id="model_id" name="model_id"
                value="<?php echo $model_id; ?>">

            <input type="hidden" class="form-control mb-3" id="spare_broken_id" name="spare_broken_id"
                value="<?php echo $spare_broken_id; ?>">
            <div class="col-12">
                <label for="model_name">
                    ประเภทอะไหล่
                    <font color="red">**</font>
                </label><br>
                <select name="spare_type_id" id="spare_type_id" class="select2-container" onchange="Get_spare_type();">
                    <option value="">กรุณาเลือก</option>
                    <?php foreach ($list as $row) { ?>
                        <option value="<?php echo $row['spare_type_id'] ?>">
                            <?php echo $row['spare_type_name'] ?>
                        </option>

                    <?php } ?>
                </select>

            </div>

            <div class="col-12">
                <br>
                <div id="show_select"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="Add_broken();">บันทึก</button>
        </div>
</form>
<script>
    $(document).ready(function () {
        Get_spare_type()
        // $(".select2").select2({
        //     width: "100%"
        // });
    });
</script>