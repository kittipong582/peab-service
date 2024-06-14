<?php include('header.php'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ข้อมูลลูกค้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
            <div class="row">
                <div class="col-6">
                    <!-- <h5>รายชื่อข้อมูลลูกค้า</h5> -->
                </div>
                <div class="col-6 text-right">

                    <a href="customer_only_form_new.php" class="btn btn-xs btn-info"><i class="fa fa-plus"></i>
                        เพิ่มข้อมูลเฉพาะลูกค้า</a>

                    <a href="customer_form_new.php" class="btn btn-xs btn-info"><i class="fa fa-plus"></i>
                        เพิ่มข้อมูล</a>


                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>ค้นหาโดย</label>
                            <select class="form-control select2" id="search_type" name="search_type" data-width="100%">
                                <option value="1" selected>รหัสลูกค้า </option>
                                <option value="2">ชื่อลูกค้า</option>
                                <option value="3">เบอร์ลูกค้า</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label>คำค้นหา</label>
                            <input type="text" name="search" class="form-control" id="search" placeholder="กรอกข้อมูลลูกค้า" autocomplete="off" value="">
                        </div>
                    </div>



                    <div class="col-md-2 col-sm-12">
                        <label> &nbsp;&nbsp;&nbsp;</label><br>
                        <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="ค้นหา">
                    </div>


                    <!-- <div class="col-md-1">
                                </div>

                                <div class="col-lg-1">
                                    <div class="form-group text-right">
                                        <a href="new_ax_import.php"
                                            class="btn btn-outline-primary btn-sm ">เพิ่มการนำเข้า</a>
                                    </div>

                                </div> -->

                </div>
            </div>
        </div>
        <div class="ibox-content">
            <!-- <div id="Loading">
                <div class="spiner-example">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div> -->
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

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {
        // GetTable();
        $(".select2").select2({
            width: "75%"
        });
    });

    function GetTable() {

        var search_type = $('#search_type').val();
        var search = $('#search').val();

        if (search == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "ajax/customer/GetTable.php",
            dataType: "html",
            data: {
                search_type: search_type,
                search: search
            },
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                // $('#Loading').hide();
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            url: "ajax/customer/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Add() {
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
                url: "ajax/customer/Add.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            GetTable();
                            $("#modal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function ModalEdit(user_id) {
        $.ajax({
            type: "post",
            url: "ajax/customer/ModalEdit.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Update() {
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
                url: "ajax/customer/Update.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            GetTable();
                            $("#modal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function ChangeStatus(button, customer_id) {
        $.ajax({
            type: "post",
            url: "ajax/customer/ChangeStatus.php",
            data: {
                customer_id: customer_id
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

    function setUserLevel(user_level) {
        if (user_level == "" || user_level == 4) {
            $("#select_branch").hide();
        } else {
            $("#select_branch").show();
        }
    }

    function ImageReadURL(input, value, show_position, old_file) {
        let fty = ["jpg", "jpeg", "png"];
        let permiss = 0;
        let file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (jQuery.inArray(file_type, fty) !== -1) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $(show_position).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else if (value == "") {
            $(show_position).attr('src', old_file);
            $(input).val("");
        } else {
            swal({
                title: "เกิดข้อผิดพลาด!",
                text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
                type: "warning"
            });
            $(show_position).attr('src', old_file);
            $(input).val("");
            return false;
        }
    }
</script>