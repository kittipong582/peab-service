<?php
include('header.php');
$customer_id = $_GET['id'];
$sql_detail = "SELECT a.*,b.customer_group_name FROM tbl_customer a
LEFT JOIN tbl_customer_group b ON b.customer_group_id = a.customer_group 
WHERE a.customer_id = '$customer_id'";
$result_detail  = mysqli_query($connection, $sql_detail);
$row_detail = mysqli_fetch_array($result_detail);
?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_list.php">ข้อมูลลูกค้า</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $row_detail['customer_name'] ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ข้อมูลลูกค้า</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6 col-12 box-input">
                            <strong>ชื่อลูกค้า</strong><br>
                            <?php echo $row_detail['customer_name'] ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>รหัสลูกค้า</strong><br>
                            <?php echo $row_detail['customer_code'] ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>ประเภทลูกค้า</strong><br>
                            <?php echo $row_detail['customer_type'] ?>
                            <?php switch ($row_detail['customer_type']) {
                                case '1':
                                    echo 'นิติบุคคล';
                                    break;
                                case '2':
                                    echo 'บุคคลธรรมดา';
                                    break;
                            } ?>
                        </div>
                        <div class="col-md-6 col-12 box-input">
                            <strong>ชื่อสำหรับออกใบกำกับภาษี</strong><br>
                            <?php echo $row_detail['invoice_name'] ?>
                        </div>
                        <div class="col-md-6 col-12 box-input">
                            <strong>เลขประจำตัวผู้เสียภาษี</strong><br>
                            <?php echo $row_detail['tax_no'] ?>
                        </div>
                        <div class="col-md-6 col-12 box-input">
                            <strong>อีเมล์</strong><br>
                            <?php echo $row_detail['email'] ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>เบอร์โทร</strong><br>
                            <?php echo $row_detail['phone'] ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>กลุ่มราคา</strong><br>
                            <?php echo $row_detail['customer_group_name'] ?>
                        </div>
                        <div class="col-12 box-input">
                            <strong>ที่อยู่สำหรับออกใบกำกับภาษี</strong><br>
                            <?php echo $row_detail['invoice_address'] ?>
                        </div>
                        <div class="col-12 box-input">
                            <strong>ที่อยู่สำหรับออกใบกำกับภาษี 2</strong><br>
                            <?php echo $row_detail['invoice_address2'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <?php include 'customer_menu.php'; ?>
        </div>
    </div>

</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>