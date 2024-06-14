<?php
include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$topic_qc_id = mysqli_real_escape_string($connect_db, $_GET['topic_qc_id']);

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>หัวข้อย่อย</h2>
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
            <li class="breadcrumb-item active">
                หัวข้อย่อย
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
                        <div class="ibox-tools">
                            <button class="btn btn-sm btn-primary"
                                onclick="GetModalChoiceAddList('<?php echo $topic_qc_id ?>')"><i class="fa fa-plus"></i>
                                เพิ่มรายการตรวจเช็ค</button>
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content animated fadeIn">
                <div id="showModal"></div>
            </div>
        </div>
    </div>

    <?php include ('footer.php'); ?>

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
            const topic_qc_id = urlParams.get('topic_qc_id');

            console.log(topic_qc_id);


            $.ajax({
                type: 'POST',
                url: "ajax/qc_choice/GetTable.php",
                data: {
                    topic_qc_id: topic_qc_id,
                    status: ($("#show_all").is(':checked')) ? '1' : '0'
                },
                dataType: "html",
                success: function (response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true,
                        "ordering": false,
                        "bDestroy": true
                    });
                    $('#Loading').hide();
                }
            });
        }

        // function GetModalChoiceAddList(topic_qc_id) {
        //     console.log(topic_qc_id)
        //     $("#myModal").modal("show");
        //     $("#showModal").load("ajax/qc_choice/modal_addlist.php");
        // }

        function GetModalChoiceAddList(topic_qc_id) {
            console.log(topic_qc_id)

            $.ajax({
                type: "POST",
                url: "ajax/qc_choice/modal_addlist.php",
                dataType: "html",
                data: {
                    topic_qc_id: topic_qc_id
                },
                success: function (response) {
                    $("#myModal .modal-content").html(response);
                    $("#myModal").modal('show');
                    $(".select2").select2({
                        width: "100%"
                    });

                }
            });
        }


        function SubmitAddChoiceList() {
            
            let checklist_name = $("#checklist_name").val();
            if (checklist_name == "") {
                swal({
                    title: 'กรุณากรอกข้อมูล',
                    text: '',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 1000
                }, function () {
                    swal.close()
                    $("#checklist_name").focus();
                });

                return false;
            }

            let formData = new FormData($("#frm_choice_add")[0]);
            formData.append('topic_qc_id', '<?php echo $topic_qc_id ?>');
           

            $.ajax({
                type: "POST",
                url: "ajax/qc_choice/add_list.php",
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
                            GetTableList();
                            swal.close();
                            $("#myModal").modal('hide');
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

        function GetModalEdit(checklist_id) {
            $("#myModal").modal("show");
            $("#showModal").load("ajax/qc_choice/modal_editlist.php", {
                checklist_id: checklist_id
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
                    url: "ajax/qc_choice/delete_list.php",
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
                                $("#myModal").modal('hide');
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

        function SubmitUpdateChoiceList(checklist_id) {

            let formData = new FormData($("#frm_choice_update")[0]);

            $.ajax({
                type: "POST",
                url: "ajax/qc_choice/update_list.php",
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
                            GetTableList();
                            swal.close();
                            $("#myModal").modal('hide');
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

        function ChangeStatus(button, checklist_id) {
            $.ajax({
                type: "post",
                url: "ajax/qc_choice/change_status.php",
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

                }
            });
        }
    </script>