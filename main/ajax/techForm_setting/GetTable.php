<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$branch_id = $_POST['branch'];
$serial_no = $_POST['serial_search'];


$job_type = $_POST['job_type'];
$product_type = $_POST['product_type'];
$form_type = $_POST['form_type'];
$oh_type = $_POST['oh_type'];

if ($job_type == 4) {

    $sql = "SELECT * FROM tbl_oh_form WHERE  product_type = '$product_type' and oh_type = '$oh_type'";
    $result  = mysqli_query($connect_db, $sql);
} else {
    $sql = "SELECT * FROM tbl_technical_form WHERE job_type = '$job_type' AND product_type = '$product_type'";
    $result  = mysqli_query($connect_db, $sql);
}
// echo $sql;
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">ข้อ</th>
            <th class="text-left">ข้อความ</th>
            <th class="text-center">ประเภท</th>
            <th class="text-center">ตัวเลือก</th>

            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        // echo $sql;
        while ($row = mysqli_fetch_array($result)) {

            if ($row['form_type'] == 1) {

                $form_type = '2 ตัวเลือก';
            } else if ($row['form_type'] == 2) {
                $form_type = 'บันทึก 2 ค่า';
            } else if ($row['form_type'] == 3) {
                $form_type = 'หมายเหตุอย่างเดียว';
            }


            if ($row['have_remark'] == 1) {
                $remark = 'มีหมายเหตุ';
            } else {
                $remark = '';
            }
        ?>
            <tr>
                <td><?php echo $row['list_order']; ?></td>
                <td class="text-left"><?php echo $row['form_name']; ?></td>
                <td class="text-center"><?php echo $form_type . " " . $remark; ?></td>
                <td class="text-center"><?php echo $row['choice1'] . '/' . $row['choice2'] ?></td>

                <td>
                    <button class="btn btn-xs btn-warning btn-block" onclick="ModalEdit('<?php echo $row['form_id'] ?>');">แก้ไข</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>