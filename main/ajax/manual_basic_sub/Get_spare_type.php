<?php
include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$data = mysqli_real_escape_string($connection, $_POST['data']);
$list = array();

$spare_type_id = $_POST['spare_type_id'];

$sql = "SELECT a.*,b.spare_type_name FROM tbl_spare_part a 
    LEFT JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id
    WHERE a.spare_type_id = '$spare_type_id' AND a.active_status = 1 ORDER BY a.spare_part_name";
$result = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $spare_part_image = ($row['spare_part_image'] != "") ? $row['spare_part_image'] : 'No-Image.png';

    $temp_array = array(
        "spare_part_id" => $row['spare_part_id'],
        "spare_part_name" => $row['spare_part_name'],
        "spare_part_image" => $spare_part_image,
        "spare_part_code" => $row['spare_part_code'],
        "spare_part_unit" => $row['spare_part_unit'],
        "spare_part_des" => $row['spare_part_des'],
        "spare_type_name" => $row['spare_type_name'],
        "active_status" => $row['active_status'],
        "default_cost" => $row['default_cost'],
    );

    array_push($list, $temp_array);
}


?>
<label for="model_name">
    อะไหล่
    <font color="red">**</font>
</label><br>
<select name="spare_part_id" id="spare_part_id" class="select2">
    <option value="">กรุณาเลือก</option>
    <?php foreach ($list as $row) { ?>
        <option value="<?php echo $row['spare_part_id'] ?>">
            <?php echo $row['spare_part_name'] ?>
        </option>

    <?php } ?>
</select>


<script>
    $(".select2").select2({
        width: "100%"
    });

</script>