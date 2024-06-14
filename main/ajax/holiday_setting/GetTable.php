<?php
    include("../../../config/main_function.php");

    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $year = $_POST['year'];
    if ($year != ""){
        $sql = "SELECT * FROM tbl_holiday WHERE YEAR(holiday_datetime) = '$year' ORDER BY holiday_datetime ASC";
        $result  = mysqli_query($connect_db, $sql);
    } else {
        $sql = "SELECT * FROM tbl_holiday ORDER BY holiday_datetime ASC";
        $result  = mysqli_query($connect_db, $sql);
    }
    
?>

<table class="table table-striped table-bordered table-hover" id="tbl_evaluate">
    <thead>
        <tr>
            <th class="text-left">ชื่อวันหยุด</th>
            <th class="text-left">วันที่</th>
            <th class="text-left">หมายเหตุ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody id="sortable">
        <?php
        // echo $sql;
        while ($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $row['holiday_name']; ?></td>
            <td><?php echo date("d-m-y", strtotime($row['holiday_datetime'])) ; ?></td>
            <td><?php echo $row['note']; ?></td>
            <td>
                <button class="btn btn-xs btn-warning btn-block"
                    onclick="ModalEdit('<?php echo $row['holiday_id'] ?>');">แก้ไข
                </button>
                <button class="btn btn-xs btn-danger btn-block" 
                    onclick="Delete('<?php echo $row['holiday_id'] ?>');">ลบ
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>