<?php include('header.php'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ประเภทงานย่อย</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ประเภทงานย่อย</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="ibox">
        <div class="ibox-title">
            <label>ชื่องานย่อย</label>
            <label>                             </label>
            <label>ประเภทงาน</label>
            <!-- <font color="red">**</font><br> -->
            <select name="" id="" style="width: 20%;" onchange="GetTable(this.value);" class="form-control select2 mb-3 ">
                <option value="1">CM</option>
                <option value="2">PM</option>
                <option value="3">Installation</option>
                <option value="5">งานอื่นๆ</option>
            </select>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> เพิ่มงานย่อย
                </button>
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



<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {
        GetTable(1);
        $(".select2").select2({});
    });

    function GetTable(type_id) {
        $.ajax({
            type: 'POST',
            url: "ajax/sub_job_type/GetTable.php",
            data: {
                type_id: type_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            url: "ajax/sub_job_type/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Add() {

        const sub_type_name = $("#sub_type_name").val();
        const job_type = $("#job_type").val();

        if (sub_type_name == "" || job_type == "") {
            swal("", "ไม่สามารถทำรายการ", "error");
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
        }, function() {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/sub_job_type/Add.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    console.log(response);

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            GetTable(1);
                            $("#modal").modal('hide');
                            $('#Loading').hide();
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function ModalEdit(sub_job_type_id) {
        $.ajax({
            type: "post",
            url: "ajax/sub_job_type/ModalEdit.php",
            data: {
                sub_job_type_id: sub_job_type_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Update() {

        const sub_type_name = $("#sub_type_name").val();
        const job_type = $("#job_type").val();

        if (sub_type_name == "" || job_type == "") {
            swal("", "ไม่สามารถทำรายการได้", "error");
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
        }, function() {

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/sub_job_type/Update.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    console.log(response);

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            GetTable(1);
                            $("#modal").modal('hide');
                            $('#Loading').hide();
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }



    function ChangeStatus(button, sub_job_type_id) {
        $.ajax({
            type: "post",
            url: "ajax/sub_job_type/ChangeStatus.php",
            data: {
                sub_job_type_id: sub_job_type_id
            },
            dataType: "json",
            success: function(response) {

                if (response.result == 1) {

                    if (response.status == 1) {
                        $(button).addClass('btn-info').removeClass('btn-danger').html('กำลังใช้งาน');
                    } else if (response.status == 0) {
                        $(button).addClass('btn-danger').removeClass('btn-info').html('ยกเลิกใช้งาน');
                    }

                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });
    }
</script>