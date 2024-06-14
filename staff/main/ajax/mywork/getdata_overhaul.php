<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT a.*,b.overhaul_id,c.brand_name,d.model_name FROM tbl_job a 
LEFT JOIN tbl_overhaul b ON a.overhaul_id = b.overhaul_id
LEFT JOIN tbl_product_brand c ON b.brand_id = c.brand_id
LEFT JOIN tbl_product_model d ON b.model_id = d.model_id
WHERE a.job_id = '$job_id' 
;";
// echo $sql ;
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

$overhaul_id = $row['overhaul_id'];

$sql_l = "SELECT a.log_id,a.return_datetime,b.*,c.brand_name,d.model_name,e.branch_name FROM tbl_overhaul_log a 
JOIN tbl_overhaul b ON a.overhaul_id = b.overhaul_id 
LEFT JOIN tbl_product_brand c ON b.brand_id = c.brand_id
LEFT JOIN tbl_product_model d ON b.model_id = d.model_id
LEFT JOIN tbl_customer_branch e ON b.current_customer_branch_id = e.customer_branch_id
WHERE a.job_id = '$job_id' ORDER BY a.create_datetime DESC ;";
// echo $sql_l;
$rs_l  = mysqli_query($connect_db, $sql_l);
// $row_l = mysqli_fetch_array($rs_l);
$num_row_l = mysqli_num_rows($rs_l);

if ($overhaul_id == "") {
    $button = "เลือกเครื่องทดแทน";
} else {
    $button = "เปลี่ยนเครื่องทดแทน";
}


?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<div class="wrapper wrapper-content" style="padding: 15px 0px 0px 0px;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">
                        <?php if ($row['close_user_id'] == NULL) { ?>
                            <button class="btn btn-success btn-md btn-block" type="button" id="check" onclick="modal_add_overhaul('<?php echo $job_id ?>')"><?php echo $button ?> </button>
                        <?php } ?>
                    </div>

                    <?php if ($overhaul_id != "") { ?>

                        <div class="ibox-content">
                            <div class="row">

                                <div class="col-9">
                                    <label><b>เครื่องทดแทนปัจจุบัน</b></label>
                                </div>

                                <div class="col-3">
                                    <button class="btn btn-info btn-sm" type="button" id="submit" onclick="submit_return('<?php echo $job_id ?>')">คืนเครื่อง</button>
                                </div>

                                <div class="col-2">
                                    <label><b>ยี่ห้อ</b></label>
                                </div>

                                <div class="col-10">
                                    <label><?php echo $row['brand_name'] ?></label>
                                </div>

                                <div class="col-2">
                                    <label><b>รุ่น</b></label>
                                </div>

                                <div class="col-10">
                                    <label><?php echo $row['model_name'] ?></label>
                                </div>

                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="ibox-content">

                            <center>
                                <h2>ไม่พบเครื่องทดแทน</h2>
                            </center>

                        </div>

                    <?php } ?>




                    <?php

                    if ($num_row_l != 0) { ?>

                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" style="width: 250%;">
                                    <thead>
                                        <tr>

                                            <th class="text-left" style="width:10%;">Serial_No</th>
                                            <th class="text-center" style="width:12%;">ประเภท</th>
                                            <th class="text-center" style="width:17%;">รายละเอียดเครื่อง</th>
                                            <th class="text-center" style="width:12%;">วันที่คืนเครื่อง</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;

                                        while ($row_l = mysqli_fetch_array($rs_l)) {

                                            $i++;

                                            // $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['receive_user_id']}' ;";
                                            // $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
                                            // $row_r = mysqli_fetch_assoc($rs_r);

                                            switch ($row_l['product_type']) {
                                                case "1":
                                                    $product_type = "เครื่องชง";
                                                    break;
                                                case "2":
                                                    $product_type = "เครื่องบด";
                                                    break;
                                                case "3":
                                                    $product_type = "เครื่องปั่น";
                                                    break;
                                                default:
                                                    $product_type = "ไม่ระบุ";
                                            }


                                        ?>


                                            <td class="text-left"><?php echo $row_l['serial_no']; ?></td>
                                            <td class="text-center"><?php echo $product_type; ?></td>
                                            <td class="text-left"><?php echo $row_l['brand_name']; ?>
                                                <br><?php echo $row_l['model_name']; ?>
                                            </td>
                                            <td class="text-left">
                                                <?php echo ($row_l['return_datetime'] == "") ? "-" : date('d-M-Y', strtotime($row_l['return_datetime'])) ?>
                                            </td>



                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php } else { ?>

                        <!-- <div class="ibox-content">
                        <center>
                            <h2>ไม่พบประวัติเครื่องทดแทน</h2>
                        </center>
                    </div> -->

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    $('table').DataTable({
        pageLength: 10,
        responsive: true,
        // sorting: disable
    });


    function modal_add_overhaul(job_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/overhaul/modal_add_overhaul.php",
            data: {
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });

    }

    function modal_qc(job_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/overhaul/modal_qc.php",
            data: {
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });

    }

    function modal_pickup(job_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/overhaul/modal_pickup.php",
            data: {
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });

    }


    function submit_return(job_id) {

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/mywork/overhaul/return_overhaul.php',
                data: {
                    job_id: job_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                        }, function() {
                            Getdata();
                        });
                    }
                    if (data.result == 0) {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "บันทึกผิดพลาด",
                            type: "error",
                        });
                    }
                }

            })
        });
    }
</script>