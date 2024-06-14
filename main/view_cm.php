<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$approve_user_id = $_SESSION['user_id'];
$id = $_GET['id'];
$type = $_GET['type'];
$job_array = array();
$job_no_array = array();
if ($type == 1) {

    $sql_check = "SELECT * FROM tbl_job WHERE job_id = '$id'";
    $result_check = mysqli_query($connection, $sql_check);
    $row_check = mysqli_fetch_array($result_check);
    $num_check = mysqli_num_rows($result_check);

    $sql_head = "SELECT job_no FROM tbl_job WHERE job_id = '$id'";
    $result_head = mysqli_query($connection, $sql_head);
    $row_head = mysqli_fetch_array($result_head);
    $job_no = $row_head['job_no'];

    ////////////////////array ไว้ทำ tab//////////////
    $temp_array = array(
        "job_id" => $id,
        "job_no" => $job_no

    );
    array_push($job_array, $temp_array);
    //////////////////////////////////////////


    $sql_spare = "SELECT IFNULL(SUM(unit_price),0) AS totall,IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '$id'";
    $result_spare = mysqli_query($connection, $sql_spare);
    $row_spare = mysqli_fetch_array($result_spare);

    $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$id'";
    $result_income = mysqli_query($connection, $sql_income);
    while ($row_income = mysqli_fetch_array($result_income)) {

        $income_total += $row_income['quantity'] * $row_income['income_amount'];
    }

    $service_total = $row_spare['totall'];


    //////////////////////////////////////

    $start = new DateTime($row_check['appointment_time_start']);
    $end = new DateTime($row_check['appointment_time_end']);

    $time = $start->diff($end);
    $diffInMinutes = $time->i; //นาที;
    $diffInHours = $time->h; //ชั่วโมง;

    $minute = $diffInMinutes;
    $hour = $diffInHours;

    $count_minute = strlen($minute);
    if ($count_minute == 1) {
        $minute = "0" . $diffInMinutes;
    }

    $count_hour = strlen($hour);
    if ($count_hour == 1) {
        $hour = "0" . $diffInHours;
    }

    $total_time = $hour . " : " . $minute;
} else if ($type == 2) {
    // echo "tesata";
    $sql_check = "SELECT * FROM tbl_group_pm WHERE group_pm_id = '$id'";
    $result_check = mysqli_query($connection, $sql_check);
    $row_check = mysqli_fetch_array($result_check);

    $sql_detail = "SELECT a.job_id,b.job_no FROM tbl_group_pm_detail a 
    LEFT JOIN tbl_job b ON a.job_id = b.job_id
     WHERE group_pm_id = '{$row_check['group_pm_id']}' ORDER BY b.job_no";
    $result_detail = mysqli_query($connection, $sql_detail);
    while ($row_detail = mysqli_fetch_array($result_detail)) {


        $sql_spare = "SELECT IFNULL(SUM(unit_price),0) AS totall,IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '{$row_detail['job_id']}'";
        $result_spare = mysqli_query($connection, $sql_spare);
        $row_spare = mysqli_fetch_array($result_spare);

        $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '{$row_detail['job_id']}'";
        $result_income = mysqli_query($connection, $sql_income);
        while ($row_income = mysqli_fetch_array($result_income)) {

            $income_total += $row_income['quantity'] * $row_income['income_amount'];
        }

        $service_total += $row_spare['totall'];


        $temp_array = array(
            "job_id" => $row_detail['job_id'],
            "job_no" => $row_detail['job_no']

        );
        array_push($job_array, $temp_array);
    }

    // echo $service_total;

    $num_check = mysqli_num_rows($result_check);
    $job_no = "กลุ่มงาน PM";


    //////////////////////////////////////

    $start = new DateTime($row_check['group_date']);
    $end = new DateTime($row_check['appointment_time_end']);

    $time = $start->diff($end);
    $diffInMinutes = $time->i; //นาที;
    $diffInHours = $time->h; //ชั่วโมง;

    $minute = $diffInMinutes;
    $hour = $diffInHours;

    $count_minute = strlen($minute);
    if ($count_minute == 1) {
        $minute = "0" . $diffInMinutes;
    }

    $count_hour = strlen($hour);
    if ($count_hour == 1) {
        $hour = "0" . $diffInHours;
    }

    $total_time = $hour . " : " . $minute;
}

if ($num_check != 1) {
    include('logout.php');
} else {
    // echo $sql_spare;
    // $sql_s_spare = "SELECT IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '$job_id'";
    // $result_s_spare  = mysqli_query($connection, $sql_s_spare);
    // $row_s_spare = mysqli_fetch_array($result_s_spare);
    // echo $sql_s_spare;
    // var_dump($job_array);
?>
    <style>
        .box-input {
            min-height: 90px;
        }

        /* tr {
                                                                                                                                            color: #676a6c;
                                                                                                                                        } */
        .classmodal1 {
            max-width: 1200px;
            margin: auto;

        }


        .classmodal2 {
            max-width: 800px;
            margin: auto;

        }
    </style>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>
                <?php echo $job_no ?>
            </h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="job_list.php">รายการงาน</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="view_cm.php?id=<?php echo $job_id; ?>&&type=<?php echo $type; ?>">
                        <?php echo $job_no ?>
                    </a>
                </li>
                <!-- <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li> -->
                <li class="breadcrumb-item active">
                    <strong>รายละเอียดงาน</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="row">
                        <div class="col-lg-3 mb-2">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa fa-money fa-4x"></i>
                                    </div>
                                    <div class="col-8 text-right">
                                        <span> ค่าบริการ </span>
                                        <h2 class="font-bold" id="total_service">
                                            <?php echo number_format($income_total); ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="widget style1 red-bg">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa fa-list-ul fa-4x"></i>
                                    </div>
                                    <div class="col-8 text-right">
                                        <span> ค่าอะไหล่ </span>
                                        <h2 class="font-bold" id="total_spare">
                                            <?php echo number_format($service_total); ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa fa-clock-o fa-4x"></i>
                                    </div>
                                    <div class="col-8 text-right">
                                        <span> ระยะเวลาซ่อม </span>
                                        <h2 class="font-bold">
                                            <?php echo $total_time ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa fa-wrench fa-4x"></i>
                                    </div>
                                    <div class="col-8 text-right">
                                        <span> จำนวนอะไหล่ </span>
                                        <h2 class="font-bold" id="spare_quantity">
                                            <?php echo $row_spare['sum_spare'] ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tabs-container2" style="margin-top: 2ex;">
                        <ul class="nav nav-tabs">
                            <?php $i = 10;
                            foreach ($job_array as $job_id) {
                                $i++;
                                if ($i == 11) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                            ?>
                                <input type="hidden" id="get<?php echo $i ?>" value="<?php echo $job_id['job_id'] ?>">
                                <li>
                                    <a class="nav-link tab_head1 <?php echo $active ?>" id="tabs_head_<?php echo $i ?>" onclick="load_Getdata('<?php echo $job_id['job_id'] ?>');" href="#tabs-<?php echo $i ?>" data-toggle="tab">
                                        <?php echo $job_id['job_no'] ?>
                                    </a>
                                </li>
                            <?php
                            } ?>
                        </ul>
                        <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                        <div class="tab-content2">
                            <div id="point_data">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered classmodal2" id="modal2" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>



        <?php include('import_script.php'); ?>
        <script>
            $(document).ready(function() {

                load_Getdata($('#get11').val());

                // all_load();

                // $(".tabs").click(function() {
                //     // alert($(this).attr('id'));
                //     $(".tabs").removeClass("active");
                //     $(".tabs h4").removeClass("font-weight-bold");
                //     $(".tabs h4").addClass("text-muted");
                //     $(this).children("h4").removeClass("text-muted");
                //     $(this).children("h4").addClass("font-weight-bold");
                //     $(this).addClass("active");

                //     current_fs = $(".active");

                //     // next_fs = $(this).attr('id');
                //     // next_fs = "#" + next_fs + "1";

                //     $("fieldset").removeClass("show");
                //     $(next_fs).addClass("show");
                //     current_fs.animate({}, {
                //         step: function() {
                //             current_fs.css({
                //                 'display': 'none',
                //                 'position': 'relative'
                //             });
                //             next_fs.css({
                //                 'display': 'block'
                //             });
                //         }
                //     });
                // });

            });

            function load_Getdata(job_id) {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/Getdata.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#point_data').html(response);
                        // all_load();
                        load_table_total_service();
                    }
                });
            }

            function all_load() {
                load_table_expend();
                load_table_total_service();
                load_table_job_payment();
                load_table_spare();
                load_fixed_detail();
                load_overhaul('<?= $row['overhaul_id'] ?>');
            }

            function load_table_spare() {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/getTable_spare.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_table_spare_part').html(response);
                        $('.spare_part_tbl').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $('#Loading_spare').hide();
                    }
                });
            }


            function load_table_expend() {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/expend/getTable_expend.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_table_expend').html(response);
                        $('.expend_tbl').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $('#Loading_expend').hide();
                    }
                });
            }



            function load_table_total_service() {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/total_service/getTable_total_service.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_table_total_service').html(response);

                        $('#Loading_total_service').hide();
                    }
                });
            }


            function load_table_job_payment() {

                var job_id = $('#job_id').val();
                var type = $('#type').val();
                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/payment/getTable_job_payment.php',
                    data: {
                        job_id: job_id,
                        type: type
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_table_payment').html(response);
                        $('.payment_tbl').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $('#Loading_payment').hide();
                    }
                });
            }

            function load_table_daily() {

                var job_id = $('#job_id').val();
                var type = $('#type').val();
                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/daily/getTable_daily.php',
                    data: {
                        job_id: job_id,
                        type: type
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_daily_table').html(response);
                        $('.daily_tbl').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $('#Loading_daily').hide();
                    }
                });
            }




            function load_repair_detail() {

                var job_id = $('#job_id').val();
                $('.img_show').hide();
                $('.spinning').show();
                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/repair_detail/getRepair_detail.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_repair_detail').html(response);
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 250,
                        });

                        $('#Loading_repair').hide();
                        $('.img_show').show();
                        $('.spinning').hide();

                    }
                });
            }




            function load_table_close_app() {

                var job_id = $('#job_id').val();
                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/close/getTable_close_app.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_close_app').html(response);
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 250,
                        });

                        $('#Loading_close').hide();


                    }
                });
            }


            function load_fixed_detail() {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/fixed_detail/getFixed_detail.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_fixed_detail').html(response);
                        $('.fixed_tbl').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $(".select2").select2({});
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 250,
                        });

                        $('#Loading_show_fixed').hide();


                    }
                });
            }




            function load_pm_detail() {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/Pm_work/getPm_detail.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_Pm_detail').html(response);
                        $('.fixed_tbl').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $(".select2").select2({});
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 250,
                        });

                        $('#Loading_show_Pm').hide();


                    }
                });
            }


            function load_overhaul(overhaul_id) {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/overhaul/show_overhaul.php',
                    data: {
                        overhaul_id: overhaul_id,
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_overhaul').html(response);
                        $('.tbl_log').DataTable({
                            pageLength: 25,
                            responsive: true,
                        });
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 250,
                        });

                        $('#Loading_overhaul').hide();


                    }
                });

            }



            function load_sub_oh() {

                var job_id = $('#job_id').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/CM_view/sub_oh/show_sub_overhaul.php',
                    data: {
                        job_id: job_id
                    },
                    dataType: 'html',
                    success: function(response) {
                        $('#show_sub_oh').html(response);

                        $('#Loading_sub_oh').hide();


                    }
                });

            }

            function Modal_menu_button(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/menu/Modal_CM_menu.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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


            function modal_image(job_id,sub_job_id) {

                // var job_id = $('#job_id').val();

                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/sub_oh/Modal_image1.php",
                    data: {
                        job_id: job_id,
                        sub_job_id: sub_job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal2 .modal-content").html(response);
                        $("#modal2").modal('show');
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



            function Modal_spare_part(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/Modal_record_spare_part.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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


            function edit_item_spare(spare_used_id, job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/Modal_edit_spare_used.php",
                    data: {
                        job_id: job_id,
                        spare_used_id: spare_used_id
                    },
                    dataType: "html",
                    success: function(response) {
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


            function Modal_set_SO(job_id, group_type) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/SO/Modal_add.php",
                    data: {
                        job_id: job_id,
                        group_type: group_type
                    },
                    dataType: "html",
                    success: function(response) {
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

            function Modal_record_expend(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/expend/Modal_record_expend.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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


            function Modal_record_income(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/income/Modal_record_income.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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


            function Modal_record_payment(job_id) {


                var type = $('#type').val();

                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/payment/Modal_record_payment.php",
                    data: {
                        job_id: job_id,
                        type: type
                    },
                    dataType: "html",
                    success: function(response) {
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



            function Modal_close_remark(job_id) {


                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close/Modal_close.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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


            function close_job_PM(job_id) {

                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close/Modal_PM_close.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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



            function Get_formPm(job_id, type) {

                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close/Form_closePm.php",
                    data: {
                        job_id: job_id,
                        type: type
                    },
                    dataType: "html",
                    success: function(response) {
                        if (type == 1) {
                            $("#btn_close_point").css("display", "block");
                            $("#btn_sumbit_point").css("display", "none");
                        } else {
                            $("#btn_sumbit_point").css("display", "block");
                            $("#btn_close_point").css("display", "none");
                        }
                        $("#form_point_close").html(response);
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

            function Get_user(branch_id, row) {

                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close/Get_user.php",
                    data: {
                        branch_id: branch_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#user_list_" + row).html(response);

                        $(".select2").select2({});

                    }
                });

            }


            function create_plan() {

                var check_plan = $('#check_plan').val();
                var PMcounter = parseInt(1);
                var plan_times = parseInt($('#plan_times').val());
                var start_help_date = $('#start_help_date').val();
                var distance_date = $('#distance_date').val();
                $('.new_pm_form').remove();
                $('.new_pm_multi_form').remove();
                var row = (PMcounter + plan_times);



                $.ajax({
                    type: 'POST',
                    url: "ajax/CM_view/close/addPM_MultiForm.php",
                    dataType: "html",
                    data: {
                        Count_Row: PMcounter,
                        start_help_date: start_help_date,
                        distance_date: distance_date,
                        plan_times: plan_times,
                        row: row,
                        check_plan: check_plan,

                    },
                    success: function(response) {


                        $("#btn_sumbit_point").css("display", "block");

                        $("#form_contact").append(response);
                        $('#PMcounter').html(function(i, val) {
                            return +val + plan_times
                        });
                        $(".delete-contact").click(function(e) {
                            $(this).parents('.new_pm_multi_form').remove();
                            $('#PMcounter').html(function(i, val) {
                                return +val - 1
                            });
                        });
                        $(".select2").select2({});
                        $(".datepicker").datepicker({
                            todayBtn: "linked",
                            keyboardNavigation: false,
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                        });
                        for (let i = 0; i < row; i++) {
                            $.ajax({
                                type: "POST",
                                url: "ajax/job/PM/GetSelectPM_User.php",
                                data: {
                                    branch_id: check_plan,
                                },
                                dataType: "html",
                                success: function(response) {
                                    $("#user_list_" + i).html(response);
                                    $(".select2").select2({});
                                }
                            });

                        }
                    }
                });
            }



            function PM_plan_Submit() {

                var formData = new FormData($("#form_planPm")[0]);
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
                        type: "post",
                        url: "ajax/CM_view/close/insert_next_pmplan.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                $("#modal").modal('hide');
                            } else {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'ไม่สามารถทำรายการได้ กรุณาลองใหม่!!',
                                    type: 'warning'
                                });
                                return false;
                            }
                        }
                    });
                });

            }


            function close_job(job_id) {

                var close_note = $('#close_note').val();

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
                        type: "post",
                        url: "ajax/CM_view/close/close_job.php",
                        data: {
                            job_id: job_id,
                            close_note: close_note
                        },

                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                $("#modal").modal('hide');
                            } else {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'ไม่สามารถทำรายการได้ กรุณาลองใหม่!!',
                                    type: 'warning'
                                });
                                return false;
                            }
                        }
                    });
                });
            }





            function modal_new_cus(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/job/quotation/modal_add_cus.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
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





            // function show_form() {

            //     $.ajax({
            //         type: "post",
            //         url: "ajax/CM_view/fixed_detail/Modal_fixed.php",
            //         data: {
            //             job_id: job_id
            //         },
            //         dataType: "html",
            //         success: function(response) {
            //             $("#modal .modal-content").html(response);
            //             $("#modal").modal('show');
            //             $('.summernote').summernote({
            //                 toolbar: false,
            //                 height: 200,
            //             });
            //             $(".select2").select2({});
            //             $(".datepicker").datepicker({
            //                 todayBtn: "linked",
            //                 keyboardNavigation: false,
            //                 format: 'dd-mm-yyyy',
            //                 autoclose: true,
            //             });
            //         }
            //     });

            // }




            function modal_fixed() {

                var job_id = $('#job_id').val();
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/fixed_detail/Modal_fixed.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 200,
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

            function Modal_add_OH(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/overhaul/Modal_add.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }



            function Modal_group_pm(job_id, customer_branch_id, have_data) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/group_pm/Modal_group.php",
                    data: {
                        job_id: job_id,
                        customer_branch_id: customer_branch_id,
                        have_data: have_data
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function Modal_group_pm_price(group_pm_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/group_pm/Modal_group_price.php",
                    data: {
                        group_pm_id: group_pm_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }



            function Modal_history_product(product_id, job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/history/Modal_history.php",
                    data: {
                        product_id: product_id,
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function Modal_expire_date(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/OH_expire/Modal_expire_date.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function Modal_close_record(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close_record/Modal_close_record.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});
                        $('.iradio_square-green').iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                        });

                    }
                });
            }



            function Modal_close_record_qc(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close_record/Modal_close_record_qc.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }

            function Modal_close_record_gs(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close_record/Modal_close_record_gs.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }

            function modal_Pm() {

                var job_id = $('#job_id').val();
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/Pm_work/Modal_Pm.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 200,
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


            function Modal_Editclose_record(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close_record/Modal_Edit.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});
                        $('.iradio_square-green').iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                        });
                    }
                });
            }


            function Modal_Editqc_record(close_record) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close_record/Modal_Edit_qcoh.php",
                    data: {
                        close_record: close_record
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function Modal_Editgs_record(close_record) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/close_record/Modal_Edit_gsoh.php",
                    data: {
                        close_record: close_record
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal1 .modal-content").html(response);
                        $("#modal1").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function Modal_cancel(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/cancel/Modal_cancel.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal2 .modal-content").html(response);
                        $("#modal2").modal('show');
                        $("#modal").modal('hide');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function Modal_daily_detail(job_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/daily/Modal_daily_detail.php",
                    data: {
                        job_id: job_id
                    },
                    dataType: "html",
                    success: function(response) {
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




            function Modal_Edit_daily(daily_id) {
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/daily/Modal_edit_daily.php",
                    data: {
                        daily_id: daily_id
                    },
                    dataType: "html",
                    success: function(response) {
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




            function change_overhaul(job_id) {

                var overhaul_id = $('#overhaul_show').val();
                $.ajax({
                    type: "post",
                    url: "ajax/CM_view/overhaul/Modal_change.php",
                    data: {
                        job_id: job_id,
                        overhaul_id: overhaul_id
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#modal .modal-content").html(response);
                        $("#modal").modal('show');
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 100,
                        });
                        $(".select2").select2({});

                    }
                });
            }


            function return_overhaul(job_id, overhaul_id) {

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
                        type: "post",
                        url: "ajax/CM_view/overhaul/return.php",
                        data: {
                            job_id: job_id,
                            overhaul_id: overhaul_id
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    load_overhaul();
                                    swal.close();

                                }, 500);
                                $("#modal").modal('hide');
                                load_Getdata($('#get11').val());
                            } else {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'ไม่สามารถทำรายการได้ !!',
                                    type: 'warning'
                                });
                                return false;
                            }


                        }
                    });

                });
            }





            function confirm_approve(job_id, result) {

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
                        type: "post",
                        url: "ajax/CM_view/job_quotation_approve/Add_approve.php",
                        data: {
                            job_id: job_id,
                            result: result
                        },

                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                $("#modal").modal('hide');
                            } else {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                                    type: 'warning'
                                });
                                return false;
                            }
                        }
                    });
                });
            }


            function confirm_qc(job_id) {

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
                        type: "post",
                        url: "ajax/CM_view/confirm_qc.php",
                        data: {
                            job_id: job_id,
                        },

                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                $("#modal").modal('hide');
                            } else {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                                    type: 'warning'
                                });
                                return false;
                            }
                        }
                    });
                });
            }



            function reset_close(job_id) {

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
                        type: "post",
                        url: "ajax/CM_view/reset_close.php",
                        data: {
                            job_id: job_id
                        },

                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                $("#modal").modal('hide');
                            } else {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                                    type: 'warning'
                                });
                                return false;
                            }
                        }
                    });
                });
            }





            function addRow() {
                var row = $('#PMcounter').html();
                var date = $('#appointment_date_' + row).val();
                $('#PMcounter').html(function(i, val) {
                    return +val + 1
                });
                var increment = $('#PMcounter').html();

                $.ajax({
                    type: 'POST',
                    url: "ajax/CM_view/fixed_detail/addRow.php",
                    dataType: "html",
                    data: {
                        Count_Row: increment,
                    },
                    success: function(response) {

                        $("#form_contact").append(response);
                        // $(".delete-contact").click(function(e) {
                        //     $(this).parents('.new_pm_form').remove();
                        // });
                        $('.summernote').summernote({
                            toolbar: false,
                            height: 200,
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





            /////////////edit////////////////
            function Update_fixed() {

                var symptom_type_id = $('.symptom_type_id').val();
                var reason_type_id = $('.reason_type_id').val();

                var formData = new FormData($("#form-edit_fiexd")[0]);

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
                }, function() {

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/CM_view/fixed_detail/update.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    swal.close();
                                }, 500);
                                $("#modal").modal('hide');


                                $(".tab_head").removeClass("active");
                                $(".tab_head h4").removeClass("font-weight-bold");
                                $(".tab_head h4").addClass("text-muted");
                                $(".tab-pane").removeClass("show");
                                $(".tab-pane").removeClass("active");
                                $("#tab_head_8").children("h4").removeClass("text-muted");
                                $("#tab_head_8").children("h4").addClass("font-weight-bold");
                                $("#tab_head_8").addClass("active");

                                current_fs = $(".active");

                                // next_fs = $(this).attr('id');
                                // next_fs = "#" + next_fs + "1";


                                $('#tab-8').addClass("active");

                                current_fs.animate({}, {
                                    step: function() {
                                        current_fs.css({
                                            'display': 'none',
                                            'position': 'relative'
                                        });
                                        next_fs.css({
                                            'display': 'block'
                                        });
                                    }
                                });
                                load_fixed_detail();
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



            function Update_pay() {

                var payment_type = $('#payment_type').val();
                var formData = new FormData($("#form-edit_payment")[0]);
                if (payment_type == '') {
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
                }, function() {

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/CM_view/payment/update_job_payment.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    swal.close();
                                }, 500);
                                $("#modal").modal('hide');


                                $(".tab_head").removeClass("active");
                                $(".tab_head h4").removeClass("font-weight-bold");
                                $(".tab_head h4").addClass("text-muted");
                                $(".tab-pane").removeClass("show");
                                $(".tab-pane").removeClass("active");
                                $("#tab_head_7").children("h4").removeClass("text-muted");
                                $("#tab_head_7").children("h4").addClass("font-weight-bold");
                                $("#tab_head_7").addClass("active");

                                current_fs = $(".active");

                                // next_fs = $(this).attr('id');
                                // next_fs = "#" + next_fs + "1";


                                $('#tab-7').addClass("active");

                                current_fs.animate({}, {
                                    step: function() {
                                        current_fs.css({
                                            'display': 'none',
                                            'position': 'relative'
                                        });
                                        next_fs.css({
                                            'display': 'block'
                                        });
                                    }
                                });
                                load_table_job_payment();


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













            ////////////////////////////////////delete

            function delete_item_income(job_income_id) {

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

                        url: 'ajax/CM_view/income/delete_item.php',

                        data: {

                            job_income_id: job_income_id

                        },

                        dataType: 'json',

                        success: function(data) {


                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    swal.close();
                                }, 500);
                                $("#modal").modal('hide');

                                load_table_total_service();
                                document.getElementById("total_service").innerHTML = data.total_service
                                document.getElementById("total_spare").innerHTML = data.all_total

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



            function delete_item_spare(spare_used_id) {

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

                        url: 'ajax/CM_view/delete_item.php',

                        data: {

                            spare_used_id: spare_used_id

                        },

                        dataType: 'json',

                        success: function(data) {


                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    swal.close();
                                }, 500);
                                $("#modal").modal('hide');

                                load_table_total_service();
                                document.getElementById("total_service").innerHTML = data.total_service
                                document.getElementById("total_spare").innerHTML = data.total_spare

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


            function Delete_daily(daily_id) {

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
                        url: 'ajax/CM_view/delete_daily.php',
                        data: {
                            daily_id: daily_id
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.result == 1) {
                                swal({
                                    title: "ดำเนินการสำเร็จ!",
                                    text: "ทำการบันทึกรายการ เรียบร้อย",
                                    type: "success",
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    swal.close();
                                }, 500);
                                load_table_daily();
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
        </script>

    <?php } ?>