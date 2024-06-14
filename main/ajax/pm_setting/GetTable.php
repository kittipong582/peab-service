<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$year_list = explode('/', $_POST['year_list']);
$year_list = date('Y-m-d', strtotime($year_list['2'] . "-" . $year_list['1'] . "-" . $year_list['0']));

$no = 1;
$sql = "SELECT * FROM tbl_pm_setting a LEFT JOIN tbl_product_type b ON a.product_type_id = b.type_id ORDER BY list_order ASC , year_list ASC";
$res = mysqli_query($connect_db, $sql);

//echo"$sql";
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:10%;">รอบการPM</th>
            <th>หัวข้อ</th>
            <th>ประเภทเครื่อง</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td>
                    <?php echo $no; ?>
                </td>
                <td>
                    <?php echo $row['list_order'] . " / " . $row['year_list']; ?>


                </td>
                <td>
                    <?php echo $row['setting_name']; ?>
                </td>
                <td>
                    <?php echo ($row["type_code"] . " " . $row["type_name"]); ?>

                </td>
                <td>
                    <a href="pm_setting_detail.php?pm_setting_id=<?php echo $row['pm_setting_id']; ?>"
                        class="btn btn-xs btn-success btn-block">ตั้งค่า</a>
                    <button type="button" class="btn btn-xs btn-warning btn-block"
                        onclick="ModalEdit('<?php echo $row['pm_setting_id'] ?>');">แก้ไข</button>
                    <button type="button" class="btn btn-xs btn-danger btn-block"
                        onclick="Delete_Pm('<?php echo $row['pm_setting_id'] ?>');">ลบ</button>

                </td>
            </tr>
            <?php $no++; ?>
        <?php } ?>
    </tbody>
</table>