<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$year_list = explode('/', $_POST['year_list']);
$year_list = date('Y-m-d', strtotime($year_list['2'] . "-" . $year_list['1'] . "-" . $year_list['0']));

$no = 1;
$sql = "SELECT * FROM tbl_product_waiting";
$res = mysqli_query($connect_db, $sql);

//echo"$sql";
?>
<div class="table-responsive">
    <?php while ($row = mysqli_fetch_assoc($res)) { ?>
        <div class="ibox-content">
            <table class="">

                <tr>
                    <td>ลูกค้า</td>
                    <td>: <?php echo $row['ref_number'] ?></td>
                </tr>
                <tr>
                    <td>Model Code</td>
                    <td>: <?php echo $row['model_code'] ?></td>
                </tr>
                <tr>
                    <td>Lot</td>
                    <td>: <?php echo $row['lot_no'] ?></td>
                </tr>
                <tr>
                    <td>import</td>
                    <td>: <?php echo $row['import_quantity'] ?></td>
                </tr>
                <tr>
                    <td>remain</td>
                    <td>: <?php echo $row['remain_quantity'] ?></td>
                </tr>

            </table>

            <a href="form_add_qc.php?id=<?php echo $row['lot_id']; ?>" class="btn btn-xs btn-info btn-block mt-3">เปิดงาน</a>
            <!-- <button type="button" class="btn btn-xs btn-warning btn-block" onclick="ModalEdit('<?php echo $row['lot_id'] ?>');">แก้ไข</button>
            <button type="button" class="btn btn-xs btn-danger btn-block" onclick="Delete_Pm('<?php echo $row['lot_id'] ?>');">ลบ</button> -->

        </div>
    <?php } ?>
</div>