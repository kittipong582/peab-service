<?php

session_start();
include ('header2.php');

$lot_id = mysqli_real_escape_string($connect_db, $_GET['id']);
// echo $sql = "SELECT * FROM tbl_product_waiting a WHERE a.lot_id = '$lot_id'";
?>
<style>
    .box-input {
        min-height: 90px;
    }

    .modal-dialog {
        max-width: 1200px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>เพิ่มงาน QC</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>เพิ่มงาน QC</strong>
                <input type="text" hidden name="lot_id" id="lot_id" value="<?php echo $lot_id ?>">
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
                        <div id="form"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include ('import_script.php'); ?>

<script>
    $(document).ready(function () {

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

        $('#search_box').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                Search();
            }
        });

        $('#btn_search').on('click', function () {
            Search();

        });
        GetForm();

    });

    function GetForm() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const id = urlParams.get('id');

        $.ajax({
            type: "POST",
            url: "ajax/form_add_qc/GetForm.php",
            data: {
                id: id
            },
            datatype: "html",
            success: function (response) {
                $("#form").show();
                $("#form").html(response);
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $('#Loading').hide();
            }
        });
    }


    function add_row_staff() {
        $('#staff_counter').html(function (i, val) {
            return +val + 1;
        });
        var increment = $('#staff_counter').html();

        $.ajax({
            url: 'ajax/form_add_qc/add_row_staff.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
            },
            success: function (data) {
                $('#Add_staff_form').append(data);
                $(".select2").select2({
                    width: "100%",
                    theme: "bootstrap",
                    placeholder: "Search"
                });

            },
        });
    }

    function add_row_branch() {
        $('#branch_counter').html(function (i, val) {
            return +val + 1;
        });
        var increment = $('#branch_counter').html();

        $.ajax({
            url: 'ajax/form_add_qc/add_row_branch.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
            },
            success: function (data) {
                $('#Add_branch_form').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            },
        });
    }

    function Submit(lot_id) {
        var responsible_user_id = $('#responsible_user_id').val();
        var appointment_date = $('#appointment_date').val();
        var machine_status = $('#machine_status').val();
        console.log(machine_status);
        if (responsible_user_id == "" || appointment_date == "" || machine_status == "" || machine_status == null) {
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

            let myForm = document.getElementById('form_add_qc');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/form_add_qc/add.php",
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
                            $("#modal").modal('hide');
                            // GetForm();
                            window.location.href = 'qc_work_list.php';
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                    if (response.result == 10) {
                        swal({
                            title: '',
                            text: 'จำนวนในคลังไม่เพียงพอ',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                }
            });

        });
    }

    function UpdateList(topic_id) {
        let update_topic_datail = $("#update_topic_datail").val();
        if (update_topic_datail == "") {
            swal({
                title: 'กรุณากรอกข้อมูล',
                text: '',
                type: 'warning',
                showConfirmButton: false,
                timer: 1000
            }, function () {
                swal.close();
                $("#topic_datail").focus();
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
                    url: "ajax/form_add_qc/add_qc.php",
                    data: {
                        topic_id: topic_id,
                        update_topic_datail: update_topic_datail
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
</script>