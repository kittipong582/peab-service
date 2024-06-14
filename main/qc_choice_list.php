<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$topic_id = mysqli_real_escape_string($connect_db, $_GET['topic_id']);
$checklist_id = $_POST['checklist_id'];

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการ Qc</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="qc_checklist.php">ตั้งค่า Qc</a>
            </li>
            <li class="breadcrumb-item active">
                <!-- <a href="qc_choice_list.php">รายการ Qc </a> -->
                <a onclick="GetChoiceList('<?php echo $topic_id; ?>')">
                    รายการ Qc
                </a>

            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
                        <div class="col-lg-12">
                            <!-- <div class="row" style="margin-left: 8px;"> -->
                            <input style=" width: 50px; height: 20px;" id="show_all" name="show_all" type="checkbox"
                                value="1" class="js-switch" onchange="GetTableList();" checked>
                            <label style="margin-top: 7px; margin-left: 10px;"> แสดงเฉพาะใช้งาน </label>
                        </div>
                        <!-- <div class="ibox-tools">
                            <button class="btn btn-sm btn-primary" onclick="GetModalChoiceAddList(<?php echo $topic_id ?>)"><i
                                    class="fa fa-plus"></i> เพิ่มหัวข้อรายการ</button>
                        </div> -->
                        <div class="ibox-tools">
                            <button class="btn btn-sm btn-primary"
                                onclick="GetModalChoiceAddList(<?php echo $topic_id; ?>)"><i class="fa fa-plus"></i>
                                เพิ่มหัวข้อรายการ</button>
                        </div>
                        <!-- <div class="">
                            <button class="btn btn-sm btn-warning"
                                onclick="activateDrag()">เปิดใช้งานการย้ายตำแหน่ง</button>
                        </div> -->


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
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content animated fadeIn">
                <div id="showModal"></div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        $(document).ready(function () {
            GetTableList();
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


        function GetTableList() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const topic_id = urlParams.get('topic_id');
            $.ajax({
                type: 'POST',
                url: "ajax/qc_choice_list/GetTable.php",
                data: {
                    topic_id: topic_id,
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


        // function GetModalChoiceAddList() {
        //     $("#Modal").modal("show");
        //     $("#showModal").load("ajax/qc_choice_list/modal_addlist.php");
        // }

        function GetModalChoiceAddList(topic_id) {

            $.ajax({
                type: "POST",
                url: "ajax/qc_choice_list/modal_addlist.php",
                dataType: "html",
                data: {
                    topic_id: topic_id
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

        function GetChoiceList(topic_id) {

            var redirect = 'qc_choice_list.php';

            $.redirectPost(redirect, {

                topic_id: topic_id

            });
        }

        function SubmitChoice(topic_id) {

            var checklist_name = $("#checklist_name").val();
            var score_name = $("#score_name").val();
            var score = $("#score").val();
            console.log(topic_id)
            score_c = 0;
            $(".score_check").map(function (index, elem) {
                let id = $(this).attr('id');
                if ($('#' + id).val() == "") {
                    score_c = 1;
                    console.log(elem)
                }
                console.log(id)
            })

            name_score = 0;
            $(".score_name_check").map(function (index, elem) {
                let id = $(this).attr('id');
                if ($('#' + id).val() == "") {
                    name_score = 1;
                    console.log(elem)
                }
                console.log(id)
            })

            if (checklist_name == "" || score_name == "" ||
                score == "" || score_c == 1 || name_score == 1) {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
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
            }, function () {

                let myForm = document.getElementById('form-add');
                let formData = new FormData(myForm);

                // Append topic_id to formData
                formData.append('topic_id', topic_id);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/qc_choice_list/add_choice.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        console.log(response);

                        if (response.result == 1) {
                            swal({
                                title: "",
                                text: "ดำเนินการสำเร็จ",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1000
                            }, function () {
                                GetTableList();
                                swal.close();
                                $("#Modal").modal('hide');
                            });
                        } else {
                            swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                        }

                    }
                });

            });
        }


        function Update(topic_id) {
            var checklist_name = $("#checklist_name").val();
            var score_name = $("#score_name").val();
            var score = $("#score").val();
            console.log(topic_id)
            score_c = 0;
            $(".score_check").map(function (index, elem) {
                let id = $(this).attr('id');
                if ($('#' + id).val() == "") {
                    score_c = 1;
                    console.log(elem)
                }
                console.log(id)
            })

            name_score = 0;
            $(".score_name_check").map(function (index, elem) {
                let id = $(this).attr('id');
                if ($('#' + id).val() == "") {
                    name_score = 1;
                    console.log(elem)
                }
                console.log(id)
            })

            if (checklist_name == "" || score_name == "" ||
                score == "" || score_c == 1 || name_score == 1) {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
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
            }, function () {

                let myForm = document.getElementById('form-edit');
                let formData = new FormData(myForm);

                // Append topic_id to formData
                formData.append('topic_id', topic_id);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "ajax/qc_choice_list/update_list.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        console.log(response);

                        if (response.result == 1) {
                            swal({
                                title: "",
                                text: "ดำเนินการสำเร็จ",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1000
                            }, function () {
                                swal.close();
                                GetTableList();
                                $("#Modal").modal('hide');
                            });
                        } else {
                            swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                        }

                    }
                });

            });
        }


        // function GetModalEdit(checklist_id, score_id, topic_id) {
        //     console.log(topic_id)
        //     $("#Modal").modal("show");
        //     $("#showModal").load("ajax/qc_choice_list/modal_editlist.php", {
        //         checklist_id: checklist_id,
        //         score_id: score_id,
        //         topic_id: topic_id
        //     });
        // }


        function GetModalEdit(topic_id, checklist_id) {
            console.log(topic_id, checklist_id);

            $.ajax({
                type: "POST",
                url: "ajax/qc_choice_list/modal_editlist.php",
                dataType: "html",
                data: {
                    topic_id: topic_id,
                    checklist_id: checklist_id
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



        function DeleteList(checklist_id) {
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
                    url: "ajax/qc_choice_list/delete_list.php",
                    data: {
                        checklist_id: checklist_id
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
                                GetTableList();
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

        function DeleteScore(checklist_id) {
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
                    url: "ajax/qc_choice_list/delete_score.php",
                    data: {
                        score_id: score_id
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
                                GetTableList();
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

        // function SubmitUpdateChoiceList() {

        //     var formData = new FormData($("#form-edit")[0]);
        //     $.ajax({
        //         type: "POST",
        //         url: "ajax/qc_choice_list/update_list.php",
        //         data: formData,
        //         cache: false,
        //         processData: false,
        //         contentType: false,
        //         dataType: "json",
        //         success: function (data) {
        //             if (data.result == 1) {
        //                 swal({
        //                     title: 'บันทึกข้อมูลสำเร็จ',
        //                     type: 'success',
        //                     showConfirmButton: false,
        //                     timer: 1500
        //                 }, function () {
        //                     GetTableList();
        //                     swal.close();
        //                     $("#Modal").modal('hide');
        //                 });
        //             } else if (data.result == 0) {
        //                 swal({
        //                     title: 'แจ้งเตือน',
        //                     text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
        //                     type: 'warning',
        //                     showConfirmButton: false,
        //                     timer: 1500
        //                 });
        //             } else if (data.result == 9) {
        //                 swal({
        //                     title: 'แจ้งเตือน',
        //                     text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
        //                     type: 'warning',
        //                     showConfirmButton: false,
        //                     timer: 1500
        //                 });
        //             }
        //         }
        //     });
        // }

        function ChangeStatus(button, checklist_id) {
            $.ajax({
                type: "post",
                url: "ajax/qc_choice_list/change_status.php",
                data: {
                    checklist_id: checklist_id
                },
                dataType: "json",
                success: function (response) {

                    if (response.result == 1) {
                        if (response.status == 1) {
                            $(button).addClass('btn-primary').removeClass('btn-danger').html('ใช้งาน');
                        } else if (response.status == 0) {
                            $(button).addClass('btn-danger').removeClass('btn-primary').html('ไม่ใช้งาน');
                            if ($("#show_all").is(':checked')) {
                                $('#tr_' + checklist_id).fadeOut(700);
                            } else {

                            }
                        }
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                    GetTableList()
                }
            });
        }

        function ShowButtonSet() {
            $("#ShowButton").hide();
            $("#HideButton").show();
            $("#SortButton").show();
            $(".td_move").show();

            $("#myTable tbody").sortable();
            $(".tr_move").css({ "cursor": "move", "border": "2px dashed" });
            $('#myTable').DataTable().destroy();
        }
        function HideButtonSet() {
            GetTableList()
        }
        function SortData() {
            let checklist_id = $("input[name='checklist_id[]']").map(function () {
                return $(this).val();
            }).get();
            swal({
                title: "ยืนยัน การจัดลำดับข้อมูล ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1AB394",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ตรวจสอบอีกครั้ง",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: 'ajax/qc_choice_list/SortFile.php',
                    type: 'POST',
                    data: {
                        checklist_id: checklist_id,
                    },
                    dataType: 'json',
                    success: function (data) {
                        $(".confirm").prop('disabled', false);
                        if (data.result == 1) {
                            GetTableList();
                            swal({
                                title: "แจ้งเตือน",
                                text: "เรียงข้อมูลสำเร็จ",
                                type: "success",
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                swal.close();
                            }, 2000);
                        } else if (data.result == 0) {
                            swal({
                                title: "แจ้งเตือน",
                                text: "เรียงข้อมูลไม่สำเร็จ",
                                type: "error",
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                swal.close();
                            }, 2000);
                        } else if (data.result == 9) {
                            swal({
                                title: "แจ้งเตือน",
                                text: "Session หมดอายุ",
                                type: "error",
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                window.location.assign("logout.php");
                                swal.close();
                            }, 2000);
                        } else {
                            swal({
                                title: "แจ้งเตือน",
                                text: "ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง",
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                    }
                });
            });
        }
    </script>