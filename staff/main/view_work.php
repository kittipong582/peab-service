<?php
session_start();
include 'header2.php';
$current_user_id = $_SESSION['user_id'];
$job_id = $_GET['id'];
$type = $_GET['type'];
if ($type == 2) {

    $sql_check = "SELECT * FROM tbl_group_pm a
    LEFT JOIN tbl_group_pm_detail b ON a.group_pm_id = b.group_pm_id
     WHERE a.group_pm_id = '$job_id'";
    $result_check = mysqli_query($connect_db, $sql_check);
    $row_check = mysqli_fetch_array($result_check);

    // echo $sql_check;
    $sql = "SELECT a.*,b.branch_name,b.district_id FROM tbl_job a  
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
WHERE a.job_id = '{$row_check['job_id']}' ;";
    // echo $sql;
    $rs = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($rs);
    $j_id = $row_check['job_id'];
    $job_no = "กลุ่มงาน PM ";

    $start_service_time = $row_check['start_service_time'];
} else if ($type == 4) {

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT a.*,b.branch_name,b.district_id,c.check_in_datetime FROM tbl_job a  
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_job_oh c ON c.job_id = a.job_id 
WHERE a.job_id = '$job_id' and user_id = '$user_id' ;";
    // echo $sql;
    $rs = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($rs);
    // $num_row = mysqli_num_rows($rs);
    $job_no = $row['job_no'];
    $j_id = $job_id;
    $start_service_time = $row['check_in_datetime'];
} else {
    $sql = "SELECT a.*,b.branch_name,b.district_id FROM tbl_job a  
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
WHERE a.job_id = '$job_id' ;";
    // echo $sql;
    $rs = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($rs);
    // $num_row = mysqli_num_rows($rs);
    $job_no = $row['job_no'];
    $j_id = $job_id;
    $start_service_time = $row['start_service_time'];
}


$sql_district = "SELECT * FROM tbl_district a 
LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
LEFT JOIN tbl_province c ON b.ref_province = c.province_id
WHERE a.district_id = '{$row['district_id']}'";
$result_district = mysqli_query($connect_db, $sql_district);
$row_district = mysqli_fetch_array($result_district);

// echo $sql_district;

switch ($row['job_type']) {
    case "1":
        $color = "cm";
        break;
    case "2":
        $color = "pm";
        break;
    case "3":
        $color = "install";
        break;
    default:
        $color = "cm";
}

//   switch ($row['close_approve_id']) {
//     case "1":
//     $status = "<span class='badge rounded-pill bg-success text-black'> ปิดงานแล้ว </span>";
//       break;
//     default:
//     $status = "<span class='badge rounded-pill bg-warning text-black'> กำลังดำเนินการ </span>";
//   }

$status = "";
if ($row['finish_service_time'] == "" && $row['close_approve_id'] == "") {
    $status = "<span class='badge rounded-pill bg-primary text-black'> กำลังดำเนินการ </span>";
} else if ($row['finish_service_time'] != "" && $row['close_approve_id'] == "") {
    $status = "<span class='badge rounded-pill bg-warning text-black'> รอปิดงาน </span>";
} else {
    $status = "<span class='badge rounded-pill bg-danger text-black'> ปิดงานแล้ว </span>";
}



?>

<?php
if ($start_service_time != "") {

    $sql_group = "SELECT * FROM  tbl_group_pm_detail b
     WHERE b.group_pm_id = '$job_id'";
    $result_group = mysqli_query($connect_db, $sql_group);
    ?>

    <br>
    <?php if ($type == 2) { ?>
        <select class="form-control select2" data-width="100%" id="job_group" onchange="get_detail();" name="job_group">
            <?php
            while ($row_group = mysqli_fetch_array($result_group)) {

                $sql_job_group = "SELECT job_id,job_no FROM tbl_job WHERE job_id = '{$row_group['job_id']}'";
                $result_job_group = mysqli_query($connect_db, $sql_job_group);
                $row_job_group = mysqli_fetch_array($result_job_group);

                ?>
                <option value="<?php echo $row_job_group['job_id'] ?>"><?php echo $row_job_group['job_no'] ?> </option>
            <?php } ?>

        </select>

        <br>
    <?php } else if ($type == 4) { ?>
            <input type="hidden" id="job_id" value="<?php echo $job_id ?>" name="job_id">
    <?php } else { ?>

            <input type="hidden" id="job_group" value="<?php echo $job_id ?>" name="job_group">
            <input type="hidden" id="type" value="<?php echo $type ?>" name="type">


    <?php } ?>

    <div id="check_check_in">


    </div>

    <br>
    <br>
    <br>
    <br>



    <?php
} else {

    $sql_job = "SELECT a.*,b.branch_code,b.branch_name AS cus_branch_name,b.google_map_link,c.serial_no,c.warranty_start_date,c.warranty_expire_date,d.brand_name,g.model_name,b.address AS baddress,b.address2 AS baddress2 FROM tbl_job a 
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
    LEFT JOIN tbl_product c ON a.product_id = c.product_id
    LEFT JOIN tbl_product_brand d ON c.brand_id = d.brand_id
    LEFT JOIN tbl_product_model g ON c.model_id = g.model_id
    WHERE a.job_id = '$j_id' ;";
    $result_job = mysqli_query($connect_db, $sql_job);
    $num_row_job = mysqli_num_rows($result_job);
    $row_job = mysqli_fetch_array($result_job);


    ////////////////////////////////////////ค่าบริการเปิดงาน/////////////////////////
    $sql_open_service = "SELECT * FROM tbl_job_open_oth_service a
LEFT JOIN tbl_income_type b ON a.service_id = b.income_type_id
 WHERE a.job_id = '$job_id' ORDER BY a.list_order";
    $result_open_service = mysqli_query($connect_db, $sql_open_service);

    // echo $sql_job;
    ?>

    <br>

    <div class="ibox mb-3 d-block">
        <div class="ibox-title">
            <h2><?php echo $job_no ?></h2>
            <font color="gray">
                <h4><?php echo $row['branch_name'] ?></h4>
            </font>
            <div class="ibox-tools"><br>
                <span class='badge rounded-pill bg-warning text-black'> รอเข้างาน </span>
            </div>
        </div>
    </div>

    <div class="ibox mb-3 d-block">

        <div class="ibox-content">

            <br>
            <div class="row">

                <div class="col-12">
                    <label><b>ชื่อร้าน</b></label>
                    <br><?php echo $row_job['branch_code'] . " - " . $row_job['cus_branch_name'] ?> <a
                        href="<?php echo $row_job['google_map_link'] ?>" target="_blank"
                        class="btn btn-info btn-xs">แผนที่</a>
                </div>

            </div>

            <br>
            <div class="row">

                <div class="col-12">
                    <label><b>ที่อยู่สาขา</b></label>
                    <br><?php echo $row_job['baddress']; ?><br><?php echo $row_job['baddress2']; ?>
                    <br><?php echo "<b>ตําบล/แขวง</b> " . $row_district['district_name_th'] . " <b>อำเภอ/เขต</b> " . $row_district['amphoe_name_th'] . " <b>จังหวัด</b> " . $row_district['province_name_th'] . "  " . $row_district['district_zipcode']; ?>
                </div>

            </div>

            <br>
            <div class="row ">
                <div class="col-12">
                    <label><b>ผู้ติดต่อ</b></label> <br><?php echo $row_job['contact_name']; ?>
                    (<?php echo $row_job['contact_position']; ?>)
                    <a href='tel:<?php echo $row_job['contact_phone']; ?>' class="btn btn-success btn-xs"><i
                            class="fa fa-phone"></i> <?php echo $row_job['contact_phone']; ?></a>
                </div>
            </div>
            <br>
            <div class="row ">
                <div class="col-12">
                    <label><b>ช่างผู้เกี่ยวข้อง</b></label> <br>
                    <?php
                    $sql_staff = "SELECT * FROM tbl_user a LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id
                    WHERE a.user_id = '$user_id';";
                    $result_staff = mysqli_query($connect_db, $sql_staff);
                    $row_staff = mysqli_fetch_array($result_staff);
                    ?>
                    <?php echo $row_staff['fullname']; ?><br>
                    <?php
                    $sql_staff2 = "SELECT a.*,b.fullname AS name_staff,c.branch_name AS team FROM tbl_job_staff a 
                    LEFT JOIN tbl_user b ON a.staff_id = b.user_id 
                    LEFT JOIN tbl_branch c ON b.branch_id = c.branch_id WHERE NOT a.staff_id = '$user_id' AND a.job_id = '$j_id'AND b.active_status = 1;";
                    $result_staff2 = mysqli_query($connect_db, $sql_staff2);

                    ?>
                    <?php while ($row_staff2 = mysqli_fetch_array($result_staff2)) { ?>
                        <?php echo $row_staff2['team'] . ' - ' . $row_staff2['name_staff']; ?>

                        <button class="btn btn-danger btn-xs"
                            onclick="Remove_Staff('<?php echo $j_id ?>','<?php echo $row_staff2['staff_id'] ?>')">ลบ</button>

                        <br><br>
                    <?php } ?>
                    <div>
                        <button class="btn btn-info btn-xs"
                            onclick="ModalAddStaff('<?php echo $j_id ?>')">เพิ่มช่าง</button>
                    </div>
                </div>
            </div>


            <?php if ($row['job_type'] == 1) { ?>
                <br>
                <div class="row">

                    <div class="col-6">
                        <label><b>อาการเสียเบื้องต้น</b></label>
                        <br><?php echo $row['initial_symptoms']; ?>
                    </div>
                </div>
            <?php } ?>
            <br>
            <?php
            $rowcount = mysqli_num_rows($result_open_service);
            if ($rowcount >= 1) { ?>
                <div class="row">

                    <div class="col-12 mb-2">
                        <label><b>ค่าบริการเปิดงาน</b></label>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                style="width: 150%;">
                                <thead>
                                    <tr>
                                        <th width="15%" class="text-center">รายการ</th>
                                        <th width="10%" class="text-right">ราคาต่อหน่วย</th>
                                        <th width="10%" class="text-right">จำนวน</th>
                                        <th width="10%" class="text-right">รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    while ($row_open_service = mysqli_fetch_array($result_open_service)) {
                                        ?>

                                        <tr id="tr_<?php echo $row['payment_id']; ?>">

                                            <td class="text-center">
                                                <?php echo "[" . $row_open_service['income_code'] . "] -" . $row_open_service['income_type_name']; ?>

                                            </td>
                                            <td class="text-right">
                                                <?php echo number_format($row_open_service['unit_cost']); ?>

                                            </td>

                                            <td class="text-right">

                                                <?php echo number_format($row_open_service['quantity']); ?>

                                            </td>
                                            <td class="text-right">
                                                <?php echo number_format($row_open_service['unit_price']); ?>
                                            </td>
                                        </tr>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            <?php } ?>

        </div>
    </div>



    <br><br>

    <div class="row mb-2">
        <div class="col-12 text-center">
            <button class="btn btn-primary btn-lg" type="button" id="check"
                onclick="modal_check('<?php echo $job_id ?>','<?php echo $type ?>')">
                บันทึกเข้างาน </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-warning btn-lg" type="button" id="check"
                onclick="modal_daily_record('<?php echo $job_id ?>','<?php echo $type ?>')">
                บันทึกประจำวัน </button>
        </div>

    </div>

    <?php
}
?>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include 'footer_view.php'; ?>
<?php include 'footer.php'; ?>

<script>
    $(document).ready(function () {
        get_detail();

        $('table').DataTable({
            pageLength: 10,
            responsive: true,
        });
    });

    function get_detail() {
        var job_id = $("#job_group").val();
        var type = $("#type").val();

        $.ajax({
            type: 'POST',
            url: "ajax/mywork/view_work_detail.php",
            data: {
                job_id: job_id,
                type: type
            },
            dataType: "html",
            success: function (response) {
                $("#check_check_in").html(response);
                Getdata();
            }
        });

    }



    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    ///////////////////////////////////////////////////////////////////////
    var timerVar = setInterval(countTimer, 1000);
    var totalSeconds = parseFloat($('#seconds').val());
    // var totalSeconds = 86390;

    function countTimer() {
        ++totalSeconds;
        var day = Math.floor(totalSeconds / (3600 * 24));
        var hour = Math.floor(totalSeconds % (3600 * 24) / 3600);
        var minute = Math.floor(totalSeconds % 3600 / 60);
        var seconds = totalSeconds % 60;
        // console.log(day);
        // if (day < 1)
        //     $("#check_day").hide();
        //     $("#day").hide();
        if (day < 10)
            day = "0" + day;
        if (hour < 10)
            hour = "0" + hour;
        if (minute < 10)
            minute = "0" + minute;
        if (seconds < 10)
            seconds = "0" + seconds;
        document.getElementById("day").innerHTML = day;
        document.getElementById("hour").innerHTML = hour;
        document.getElementById("minute").innerHTML = minute;
        document.getElementById("second").innerHTML = seconds;
    }
    ///////////////////////////////////////////////////////////////////////

    function modal_check(job_id, type) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/modal_check.php",
            data: {
                job_id: job_id,
                type: type
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
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


    function modal_daily_record(job_id, type) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/modal_daily_record.php",
            data: {
                job_id: job_id,
                type: type
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
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

    function Getdata() {

        var job_id = $("#job_id").val();
        var menu = $("#menu").val();

        if (menu == 1) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/overview.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 2) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/record_sparepart_service.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 3) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/getdata_overhaul.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 4) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/getdata_daily.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 5) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/get_expend.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 6) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/get_payment.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 7) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/record_finish_job.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 8) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/record_qc.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 9) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/record_repair.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }


        if (menu == 10) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/overview_detail.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 11) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/sub_job_oh.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 12) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/report_form.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }

        if (menu == 13) {

            $.ajax({
                type: 'POST',
                url: "ajax/mywork/record_Pm.php",
                data: {
                    job_id: job_id
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                }
            });
        }



    }


    function Submit1() {

        var payment_type = $('#payment_type').val();
        var branch_cost = $('#branch_cost').val();
        var formData = new FormData($("#form-add_payment")[0]);
        if (payment_type > 0) {
            var cash_amount = $('#cash_amount').val();
            var transfer_amount = $('#transfer_amount').val();
            if (cash_amount == 0 && transfer_amount == 0)
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลเก็บเงินหน้าร้านให้ครบถ้วน',
                    type: 'error'
                });
            return false;
        }
        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function () {

            swal({
                title: "Loading",
                text: "Loading...",
                showCancelButton: false,
                showConfirmButton: false
                //icon: "success"
            });

            $.ajax({
                type: 'POST',
                url: 'ajax/mywork/payment/Add_job_payment.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                        }, function () {
                            Getdata();
                        });


                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });
    }

    function Submit_fixed() {

        var symptom_type_id = $('.symptom_type_id').val();
        var reason_type_id = $('.reason_type_id').val();

        var formData = new FormData($("#form-add_fiexd")[0]);

        if (symptom_type_id == "" || reason_type_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function () {


            swal({
                title: "Loading",
                text: "Loading...",
                showCancelButton: false,
                showConfirmButton: false
                //icon: "success"
            });

            $.ajax({
                type: 'POST',
                url: 'ajax/mywork/repair/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');


                        Getdata();

                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }

    function delete_img_repair(image_id, fixed_id) {

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function () {

            $.ajax({

                type: 'POST',

                url: 'ajax/mywork/repair/delete_image.php',

                data: {
                    image_id: image_id
                },
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 500);
                        view_detail(fixed_id);

                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }

            });
        });

    }

    function ModalAddStaff(j_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/repair/Modal_addstaff.php",
            dataType: "html",
            data: {
                j_id: j_id
            },
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });

    }

    function Submit_Staff() {
        let formData = new FormData($("#form-add_staff")[0]);
        var staff_id = $("#staff_id ").val();

        if (staff_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาเลือกช่าง',
                type: 'error'
            });
            return false;
        }

        $.ajax({
            type: "POST",
            url: "ajax/mywork/repair/Add_Staff.php",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                if (data.result == 1) {
                    swal({
                        title: 'บันทึกข้อมูลสำเร็จ',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }, function () {
                        swal.close();
                        location.reload();
                        $("#modal").modal('hide');
                    });
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (data.result == 9) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }


    function Remove_Staff(j_id, staff_id) {
        swal({
            title: "แจ้งเตือน",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5564",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/mywork/repair/Remove_Staff.php",
                data: {
                    j_id: j_id,
                    staff_id: staff_id,
                },
                beforeSend: function () {
                    swal({
                        title: "กำลังทำการบันทึก",
                        text: "กรุณารอสักครู่",
                        imageUrl: "ajax/ajax-loader.gif",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect. Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error. ' + jqXHR.responseText;
                    }

                    swal({
                        title: "แจ้งเตือน",
                        text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                        type: "error",
                        showConfirmButton: true
                    });
                },
                success: function (response) {
                    if (response.result == 1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            location.reload();

                        });
                    } else if (response.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });
    }
</script>