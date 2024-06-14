<?php
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$year_list = explode('/', $_POST['year_list']);
$year_list = date('Y-m-d', strtotime($year_list['2'] . "-" . $year_list['1'] . "-" . $year_list['0']));

$no = 1;
$sql = "SELECT * FROM tbl_product_waiting";
$res = mysqli_query($connect_db, $sql);

//echo"$sql";
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th>Customer Order No.</th>
            <th>รหัสสินค้า</th>
            <th>ล๊อต</th>
            <th>จำนวนรวม</th>
            <th>import_quantity</th>
            <th>remain_quantity</th>
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
                    <?php echo $row['ref_number'] ?>
                </td>
                <td>
                    <?php echo $row['model_code'] ?>
                </td>
                <td>
                    <?php echo $row['lot_no'] ?>
                </td>
                <td>
                    <?php echo $row['quantity'] ?>
                </td>
                <td>
                    <?php echo $row['import_quantity'] ?>
                </td>
                <td>
                    <?php echo $row['remain_quantity'] ?>
                </td>
                <td>
                    <a href="form_add_qc.php?id=<?php echo $row['lot_id']; ?>"
                        class="btn btn-xs btn-info btn-block">เปิดงาน</a>

                    <!-- <button type="button" class="btn btn-xs btn-warning btn-block"
                        onclick="ModalEdit('<?php echo $row['lot_id'] ?>');">แก้ไข</button> -->
                    <button type="button" class="btn btn-xs btn-danger btn-block"
                        onclick="Delete_lot('<?php echo $row['lot_id'] ?>');">ลบ</button>

                </td>
            </tr>
            <?php $no++; ?>
        <?php } ?>
    </tbody>
</table>