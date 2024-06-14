<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$amphoe_id = $_POST['amphoe_id'];


?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;" class="text-center">#</th>
            <th style="width:25%;" class="text-center">เขต/อำเภอ</th>
            <th style="width:25%;" class="text-center">รหัสไปรษณีย์</th>

            <th style="width:15%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $sql = "SELECT district_id,district_name_th,district_zipcode FROM tbl_district  
         WHERE ref_amphoe ='$amphoe_id' ORDER BY district_name_th";
        $result  = mysqli_query($connect_db, $sql);
        while ($row = mysqli_fetch_array($result)) {

        ?>
            <tr>
                <td class="text-center"><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['district_name_th']; ?></td>
                <td class="text-center"><?php echo $row['district_zipcode']; ?></td>

                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs" onclick="ModalEdit_District('<?php echo $row['district_id']; ?>')">แก้ไข</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>