<?php

session_start();

include('header.php');

$secure = "PveG!2:N(lNOl*n";

$connection = connectDB($secure);

$appraisal_id = $_GET['appraisal_id'];
$job_order_id = $_GET['id'];

$sql1 = "SELECT * FROM tbl_appraisal_head a
LEFT JOIN tbl_appraisal_product b ON b.appraisal_id = a.appraisal_id 
WHERE a.appraisal_id = '$appraisal_id' ";
$rs1 = mysqli_query($connection, $sql1) or die($connection->error);
$row1 = mysqli_fetch_array($rs1);

$sql = "SELECT * FROM tbl_job_order a 
LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id
WHERE a.job_order_id = '$job_order_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_array($rs);



?>
<style>
    input.total {

        text-align: right;

    }

    input.vat {

        text-align: right;

    }

    input.grand_total {
        text-align: right;
    }


    input.min_quantity {
        text-align: right;
    }

    input.unit_price {
        text-align: right;
    }

    input.discount {
        text-align: right;
    }


    input.total_p_p {
        text-align: right;
    }

    input.total_count {
        text-align: right;
    }

    input.cost_p_p {
        text-align: right;
    }


    input.unit_sale {
        text-align: right;
    }

    input.p_sale {
        text-align: right;
    }


    input.p_profit {
        text-align: right;
    }

    input.total_profit {
        text-align: right;
    }


    input.total {
        text-align: right;
    }

    input.vat {
        text-align: right;
    }


    input.vat_price {
        text-align: right;
    }

    input.grand_total {
        text-align: right;
    }
</style>





<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">

        <h2>ใบสั่งงาน <?= $row['job_no'] . " - [ "  . $row['contact_name'] . " ] " ?></h2>

        <ol class="breadcrumb">

            <li class="breadcrumb-item">

                <a href="index.php">หน้าหลัก</a>

            </li>

            <li class="breadcrumb-item active">

                <a href="job_order_list.php">รายการใบสั่งงาน</a>

            </li>

            <li class="breadcrumb-item active">

                <a href="view_order.php?id=<?= $job_order_id ?>">รายละเอียด</a>

            </li>

            <li class="breadcrumb-item active">

                <a href="appraisal.php?id=<?= $job_order_id ?>">รายการใบประเมินราคา</a>

            </li>

            <li class="breadcrumb-item active">

                <a href="view_contation.php?id=<?= $appraisal_id ?>">รายละเอียดใบประเมินราคา</a>

            </li>

        </ol>

    </div>

</div>



<!-- ============ content Start ============= -->

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-lg-10">

            <div class="ibox">

                <? $text = strip_tags($row['approve_note'], 'p'); ?>

                <div class="ibox-title">
                    <div class="row">
                        <div class="col-3">
                            <label>
                                รายละเอียดใบประเมินราคา
                            </label>
                        </div>
                    </div>

                    <div class="ibox-tools">

                    </div>

                </div>

                <div class="ibox-content">



                    <input type="hidden" name="appraisal_id" id="appraisal_id" value="<?php echo $appraisal_id ?>">

                    <div class="row mt-2">

                        <div class="col-4">

                            <div class="form-group">

                                <label><strong>เลขที่งาน</strong></label>

                                <input type="text" name="job_no" class="form-control" id="่job_no" readonly value="<?php echo $row['job_no'] ?>">

                            </div>

                        </div>


                        <div class="col-4 ">

                            <div class="form-group">

                                <label><strong>ชื่อผลิตภัณฑ์ (TH)</strong></label>

                                <input type="text" name="product_name_th" class="form-control" readonly id="product_name_th" value="<?php echo $row['product_name_th'] ?>">

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group">

                                <label><strong>ชื่อผลิตภัณฑ์ (EN)</strong></label>

                                <input type="text" name="product_name_en" class="form-control" readonly id="product_name_en" value="<?php echo $row['product_name_en'] ?>">

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group">

                                <label><strong>ลูกค้า</strong></label>

                                <input type="text" name="email" readonly class="form-control" id="email" value="<?php echo $row['contact_name'] ?>">

                            </div>

                        </div>



                        <div class="col-4">

                            <div class="form-group">

                                <label><strong>กำหนดส่ง</strong></label>

                                <input type="text" name="duedate" class="form-control" id="duedate" readonly value="<?php echo date('d-m-Y', strtotime($row['duedate'])) ?>">

                            </div>

                        </div>


                    </div>


                    <div class="table-responsive">

                        <table class="table table-striped dataTables-example" id="table_add">

                            <thead>

                                <tr>

                                    <th width="3%">#</th>

                                    <th width="10%">รหัส</th>

                                    <th width="15%">รายการ</th>


                                    <th width="8%">ขนาด</th>

                                    <th width="12%">จำนวน</th>

                                    <th width="12%">ราคา/หน่วย</th>

                                    <th width="12%">รวมต้นทุน</th>

                                    <th width="12%">รวมทั้งหมด</th>


                                </tr>

                            </thead>

                            <tbody>


                                <?php
                                $i = 0;
                                $sql_detail = "SELECT * FROM tbl_appraisal_product WHERE appraisal_id = '$appraisal_id'";
                                $rs_detail = mysqli_query($connection, $sql_detail) or die($connection->error);

                                while ($row_detail = mysqli_fetch_array($rs_detail)) {

                                
                                    $i++;
                                ?>


                                    <tr id="tr_<?php echo $row['job_package_id']; ?>">

                                        <td><label id="no_1"><?php echo $i ?></label></td>

                                        <td>

                                            <input type="text" id="order_code_1" name="order_code[]" class="form-control" readonly value="<?php echo $row_detail['detail_code'] ?>" autocomplete="off">

                                        </td>

                                        <td>


                                            <input type="text" id="min_quantity" name="min_quantity" class="form-control " readonly value="<?php echo $row_detail['order_list'] ?>" autocomplete="off">

                                        </td>

                                        <td>
                                            <input type="text" id="size" name="size" class="form-control " readonly value="<?php echo $row_detail['size'] ?>" autocomplete="off">

                                        </td>


                                        <td> <input type="text" id="discount" name="discount" class="form-control min_quantity" readonly value="<?php echo number_format($row_detail['quantity']) ?>" autocomplete="off">
                                        </td>


                                        <td>
                                            <input type="text" id="total_count" name="total_count" class="form-control total_count" readonly value="<?php echo number_format($row_detail['price'], 2) ?>" autocomplete="off">


                                        </td>

                                        <td>
                                            <input type="text" id="total_count" name="total_count" class="form-control total_count" readonly value="<?php echo number_format($row_detail['cost'], 2) ?>" autocomplete="off">

                                        </td>

                                        <td>
                                            <input type="text" id="total_count" name="total_count" class="form-control total_count" readonly value="<?php echo number_format($row_detail['total_price'], 2) ?>" autocomplete="off">

                                        </td>


                                    </tr>

                                <? } ?>
                            </tbody>

                        </table>


                    </div><br>

                    <div class="row">

                        <div class="col-5"></div>


                        <div class="col-2">
                            <div class="form-group">
                                <label style="font-size: 15px;"><strong>ราคาทุน/ชิ้น</strong></label>

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">

                                <input type="text" id="total_p_p" name="total_p_p" class="form-control total_p_p" value="<?php echo number_format($row1['cp_p'], 2) ?>" readonly autocomplete="off">

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">

                                <input type="text" id="cost_p_p" name="cost_p_p" onchange="cal_sell()" value="<?php echo number_format($row1['total_cost_price'], 2) ?>" class="form-control cost_p_p" readonly autocomplete="off">

                            </div>
                        </div>

                        <div class="col-1"></div>

                        <div class="col-5"></div>


                        <div class="col-2">
                            <div class="form-group">
                                <label style="font-size: 15px;"><strong>ราคาตั้งขาย</strong></label>

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">

                                <input type="text" id="unit_sale" name="unit_sale" class="form-control unit_sale" value="<?php echo number_format($row1['unit_sale'], 2) ?>" readonly autocomplete="off">

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">

                                <input type="text" id="p_sale" name="p_sale" class="form-control p_sale" readonly value="<?php echo number_format($row1['p_sale'], 2) ?>" autocomplete="off">

                            </div>
                        </div>

                        <div class="col-1"></div>

                        <div class="col-5"></div>

                        <div class="col-2">
                            <div class="form-group">
                                <label style="font-size: 15px;"><strong>กำไร/ชิ้น</strong></label>

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">

                                <input type="text" id="p_profit" name="p_profit" class="form-control p_profit" readonly value="<?php echo number_format($row1['p_profit'], 2) ?>" autocomplete="off">

                            </div>
                        </div>
                        <div class="col-1"></div>


                        <div class="col-5"></div>

                        <div class="col-2">
                            <div class="form-group">
                                <label style="font-size: 15px;"><strong>กำไรทั้งหมด</strong></label>

                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">

                                <input type="text" id="total_profit" name="total_profit" class="form-control total_profit" value="<?php echo number_format($row1['total_profit'], 2) ?>" readonly autocomplete="off">

                            </div>
                        </div>

                        <div class="col-1"></div>

                    </div>



                    <div class="row">

                        <div class="col-2"></div>
                        <div class="col-3">
                            <div class="form-group">

                                <label><strong>ราคารวม / Total</strong></label>
                                <input type="text" id="total" name="total" readonly class="form-control total" value="<?php echo number_format($row1['total'], 2) ?>" autocomplete="off">

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">

                                <label><strong>VAT%</strong></label>
                                <input type="text" id="vat" name="vat" class="form-control vat" readonly onchange="Vat_f();" value="<?php echo number_format($row1['vat_percent'], 2) ?>" autocomplete="off">

                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">

                                <label><strong>VAT Price</strong></label>
                                <input type="text" id="vat_price" name="vat_price" class="form-control vat_price" readonly value="<?php echo number_format($row1['vat_price'], 2) ?>" autocomplete="off">

                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">

                                <label><strong>ราคาทั้งสิ้น / Grand Total</strong></label>
                                <input type="text" id="grand_total" readonly name="grand_total" class="form-control grand_total" value="<?php echo number_format($row1['grand_total'], 2) ?>" autocomplete="off">

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">

                                <label><strong>หมายเหตุ</strong></label>

                                <textarea class="summernote1" name="remark" id="remark"><?php echo $row1['remark'] ?></textarea>

                            </div>
                        </div>




                    </div>



                    <hr>

                </div>
            </div>

        </div>

        <?php include('ajax/menu/MenuEventRight.php'); ?>

    </div>

</div>


<?php include('import_script.php') ?>

<script>
    $(".select2").select2({

        width: "100%"
    });


    $('.summernote1').summernote({

        toolbar: false,
        height: 100,

    });
    $('.summernote1').summernote('disable');
</script>