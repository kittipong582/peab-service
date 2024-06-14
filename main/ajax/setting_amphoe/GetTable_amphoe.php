<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$province_id = $_POST['province_id'];


?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;" class="text-center">#</th>
            <th style="width:25%;" class="text-center">เขต/อำเภอ</th>
            <th style="width:25%;" class="text-center">แขวง/ตำบล ทั้งหมด</th>

            <th style="width:15%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $sql = "SELECT amphoe_id,amphoe_name_th FROM tbl_amphoe  
         WHERE ref_province ='$province_id' ORDER BY amphoe_name_th";
        $result  = mysqli_query($connect_db, $sql);
        while ($row = mysqli_fetch_array($result)) {

            
            $sql_num = "SELECT COUNT(district_id) as district_count FROM tbl_district WHERE ref_amphoe = '{$row['amphoe_id']}'";
            $result_num  = mysqli_query($connect_db, $sql_num);
            $row_num = mysqli_fetch_array($result_num);

        ?>
            <tr>
                <td class="text-center"><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['amphoe_name_th']; ?></td>
                <td class="text-center"><?php echo $row_num['district_count']; ?></td>

                <td class="text-center">
                    
                    <a href="setting_view_district.php?id=<?php echo $row['amphoe_id'] ?>" class="btn btn-xs btn-success ">รายละเอียด</a>
                    <button type="button" class="btn btn-warning btn-xs" onclick="ModalEdit_Amphoe('<?php echo $row['amphoe_id']; ?>')">แก้ไข</button>

                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>