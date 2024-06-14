<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;" class="text-center">#</th>
            <th style="width:25%;" class="text-center">จังหวัด</th>
            <th style="width:25%;" class="text-center">อำเภอ/เขต ทั้งมหด</th>
            <th style="width:15%;" class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $sql = "SELECT province_id,province_name_th FROM tbl_province a 
         ORDER BY province_name_th";
        $result  = mysqli_query($connect_db, $sql);
        while ($row = mysqli_fetch_array($result)) {

            $sql_num = "SELECT COUNT(amphoe_id) as amphoe_count FROM tbl_amphoe WHERE ref_province = '{$row['province_id']}'";
            $result_num  = mysqli_query($connect_db, $sql_num);
            $row_num = mysqli_fetch_array($result_num);
        ?>
            <tr>
                <td class="text-center"><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['province_name_th']; ?></td>
                <td class="text-center"><?php echo $row_num['amphoe_count']; ?></td>

                <td class="text-center">

                    <a href="setting_view_amphoe.php?id=<?php echo $row['province_id'] ?>" class="btn btn-xs btn-success ">รายละเอียด</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>