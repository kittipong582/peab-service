<?php
include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qc_id = $_GET["qc_id"];
// $audit_id = mysqli_real_escape_string($connect_db, $_GET['audit_id']);

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการ QC</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="qc_form.php">ตั้งค่า QC</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="qc_checklist.php">รายการ QC</a>
            </li>
            <!-- <li class="breadcrumb-item active">
                <strong>รายการ Qc </strong>
            </li> -->
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="col-lg-12">
                            <!-- <div class="row" style="margin-left: 8px;"> -->
                            <input style=" width: 50px; height: 20px;" id="show_all" name="show_all" type="checkbox"
                                value="1" class="js-switch" onchange="GetTable();" checked>
                            <label style="margin-top: 7px; margin-left: 10px;"> แสดงเฉพาะใช้งาน </label>
                        </div>

                        <div class="ibox-tools">
                            <!-- <button class="btn btn-sm btn-primary"
                                onclick="GetModalAddList(<?php echo $audit_id; ?>)"><i class="fa fa-plus"></i>
                                เพิ่มรายการ</button> -->
                            <button class="btn btn-sm btn-primary" onclick="GetModalAddList('<?php echo $qc_id ?>')"><i
                                    class="fa fa-plus"></i>
                                เพิ่มรายการ</button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id="Loading">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="show_data"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content animated fadeIn">
                <div id="showModal"></div>
            </div>
        </div>
    </div>

    <?php include ('footer.php'); ?>

    <script>
        $(document).ready(function () {
            GetTable();
        });

        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: false,
            format: 'dd/mm/yyyy',
            thaiyear: false,
            // language: 'th', //Set เป็นปี พ.ศ.
            autoclose: true
        });


        $(".select2").select2({
            width: "75%"
        });

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, {
            color: '#1AB394'
        });

        function GetTable() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const qc_id = urlParams.get('qc_id');
       
            $.ajax({
                type: 'POST',
                url: "ajax/qc_checklist/GetTable.php",
                data: {
                    qc_id: qc_id,
                    status: ($("#show_all").is(':checked')) ? '1' : '0'
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true,
                        "ordering": false
                    });
                    $('#Loading').hide();
                }
            });
        }

        // function GetModalAddList(audit_id) {
        //     $("#Modal").modal("show");
        //     $("#showModal").load("ajax/audit_checklist/modal_addlist.php");
        // }




        function GetModalAddList(qc_id) {
       
            $.ajax({
                type: "POST",
                url: "ajax/qc_checklist/modal_addlist.php",
                dataType: "html",
                data: {
                    qc_id: qc_id
                },
                success: function (response) {
                    $("#Modal .modal-content").html(response);
                    $("#Modal").modal('show');
                    $(".select2").select2({
                        width: "100%"
                    });

                }
            });
        }

        function SubmitAddList() {
            let topic_detail = $("#topic_detail").val();
            let qc_id = $("#qc_id").val();

            if (topic_detail == "") {

                swal({
                    title: 'กรุณากรอกข้อมูล',
                    text: '',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 1000
                }, function () {
                    swal.close();
                    $("#topic_detail").focus();
                });

                return false;
            }

            $.ajax({
                type: "POST",
                url: "ajax/qc_checklist/add_list.php",
                data: {
                    topic_detail: topic_detail,
                    qc_id: qc_id

                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'บันทึกสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function () {
                            GetTable()
                            swal.close();
                            $("#Modal").modal('hide');
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


        $.extend({
            redirectPost: function (location, args) {
                var form = '';
                $.each(args, function (key, value) {
                    form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                });
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body')
                    .submit();
            }
        });

        function GetChoiceList(topic_qc_id) {

            var redirect = 'qc_choice_list.php';

            $.redirectPost(redirect, {

                topic_qc_id: topic_qc_id,

            });
        }

        function GetModalEdit(topic_qc_id) {
            // console.log(topic_qc_id);
            $("#Modal").modal("show");
            $("#showModal").load("ajax/qc_checklist/modal_editlist.php", {
                topic_qc_id: topic_qc_id
            });
        }

        function DeleteList(topic_qc_id) {
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
                    type: "POST",
                    url: "ajax/qc_checklist/delete_list.php",
                    data: {
                        topic_qc_id: topic_qc_id
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.result == 1) {
                            swal({
                                title: 'ลบข้อมูลสำเร็จ',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            }, function () {
                                GetTable()
                                swal.close();
                                $("#Modal").modal('hide');
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
            })
        }

        function UpdateList(topic_qc_id) {
            let topic_detail = $("#topic_detail").val();
            if (topic_detail == "") {
                swal({
                    title: 'กรุณากรอกข้อมูล',
                    text: '',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 1000
                }, function () {
                    swal.close();
                    $("#topic_detail").focus();
                });

                return false;
            }
            swal({
                title: "",
                text: "กรุณายืนยันการทำรายการ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00FF00",
                confirmButtonText: "ยืนยัน",
                cancelButtonColor: "#DD6B55",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/qc_checklist/update_list.php",
                        data: {
                            topic_qc_id: topic_qc_id,
                            topic_detail: topic_detail
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.result == 1) {
                                swal({
                                    title: 'บันทึกข้อมูลสำเร็จ',
                                    type: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }, function () {
                                    GetTable();
                                    swal.close();
                                    $("#Modal").modal('hide');
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
            });
        }


        function ChangeStatus(button, topic_qc_id) {
            $.ajax({
                type: "post",
                url: "ajax/qc_checklist/change_status.php",
                data: {
                    topic_qc_id: topic_qc_id
                },
                dataType: "json",
                success: function (response) {

                    if (response.result == 1) {
                        if (response.status == 1) {
                            $(button).addClass('btn-primary').removeClass('btn-danger').html('ใช้งาน');
                        } else if (response.status == 0) {
                            $(button).addClass('btn-danger').removeClass('btn-primary').html('ไม่ใช้งาน');
                        }
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                    GetTable()
                }
            });
        }

    </script>