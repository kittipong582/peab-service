<?php include('header.php'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ประเภทการแจ้งเหตุ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ประเภทการแจ้งเหตุ</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="ibox">
        <div class="ibox-title">
            <label>ประเภทการแจ้งเหตุ</label>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> เพิ่มประเภท
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

    function GetTable() {
        $.ajax({
            type: 'POST',
            url: "ajax/reason/GetTable.php",
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
            url: "ajax/reason/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Add() {

        var reason_type_name = $("#sub_type_name").val();


        if (reason_type_name == "") {
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
                url: "ajax/reason/Add.php",
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

    function ModalEdit(reason_type_id) {
        $.ajax({
            type: "post",
            url: "ajax/reason/ModalEdit.php",
            data: {
                reason_type_id: reason_type_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Update() {

        var reason_type_name = $("#sub_type_name").val();


if (reason_type_name == "") {
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

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/reason/Update.php",
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



    function ChangeStatus(button, reason_type_id) {
        $.ajax({
            type: "post",
            url: "ajax/reason/ChangeStatus.php",
            data: {
                reason_type_id: reason_type_id
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