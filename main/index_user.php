<?php include('header.php'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ผู้ใช้งานระบบ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ผู้ใช้งานระบบ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <!-- <h5>รายชื่อผู้ใช้งานระบบ</h5> -->
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> เพิ่มผู้ใช้งานระบบ
                </button>
            </div>

            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>เขต</label>
                            <select class="form-control select2" id="zone" name="zone" data-width="100%" onchange="GetBranch(this.value)">
                                <option value="x" selected>ทั้งหมด </option>

                                <?php

                                $sql_z = "SELECT zone_id,zone_name  FROM tbl_zone ;";
                                $rs_z = mysqli_query($connection, $sql_z);
                                while ($row_z = mysqli_fetch_assoc($rs_z)) {

                                ?>

                                    <option value="<?php echo $row_z['zone_id'] ?>">
                                        <?php echo $row_z['zone_name'] ?></option>


                                <?php } ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-2" id="get_branch">
                        <div class="form-group">
                            <label>ทีม</label>
                            <select class="form-control select2" id="branch" name="branch" data-width="100%">
                                <option value="x" selected>ทั้งหมด </option>

                                <?php

                                $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                $rs_b = mysqli_query($connection, $sql_b);
                                while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                ?>

                                    <option value="<?php echo $row_b['branch_id'] ?>">
                                        <?php echo $row_b['branch_name'] ?></option>


                                <?php } ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>สิทธิ์การใช้งาน</label>
                            <select class="form-control select2" id="user_level" name="user_level" data-width="100%">
                                <option value="x" selected>ทั้งหมด </option>
                                <option value="1">ทั่วไป </option>
                                <option value="2">หัวหน้าสาขา </option>
                                <option value="3">หัวหน้าเขต </option>
                                <option value="4">ส่วนกลาง </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3" id="get_user">
                        <div class="form-group">
                            <label>คำค้นหา</label>
                            <input type="text" name="search" class="form-control" id="search" placeholder="ชื่อหรือเบอร์โทรศัพท์" autocomplete="off" value="">
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
        GetTable();
        $(".select2").select2({
            width: "75%"
        });
    });

    function GetBranch(zone_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/user/GetBranch.php',
            data: {
                zone_id: zone_id
            },
            dataType: 'html',
            success: function(response) {
                $('#get_branch').html(response);
                $("#branch").select2();

            }
        });

    }

    function GetTable() {

        var zone = $('#zone').val();
        var branch = $('#branch').val();
        var user_level = $('#user_level').val();
        var search = $('#search').val();

        $.ajax({
            type: 'POST',
            url: "ajax/user/GetTable.php",
            dataType: "html",
            data: {
                zone: zone,
                branch: branch,
                user_level: user_level,
                search: search
            },
            success: function(response) {
                $("#show_data").html(response);
                $('#table_user').DataTable({
                    pageLength: 25,
                    responsive: true,
                    "columns": [{
                            "width": "35px"
                        },
                        {
                            "width": "35px"
                        },
                        {
                            "width": "450px"
                        },
                        {
                            "width": "100px"
                        },
                        {
                            "width": "50px"
                        },
                        {
                            "width": "50px"
                        },
                        {
                            "width": "350px"
                        },
                        {
                            "width": "30px"
                        },
                        {
                            "width": "30px"
                        }
                    ],
                });
                $('#Loading').hide();
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            url: "ajax/user/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });

            }
        });
    }

    function Add() {

        var chk = $('#user_level_1').val();
        var username = $('#username').val();
        var fullname = $('#fullname').val();
        var mobile_phone = $('#mobile_phone').val();

        if (chk == "" || username == "" || fullname == "" || mobile_phone == "") {

            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;

        }

        if (chk == 1 || chk == 2) {
            var branch_id = $('#branch_id').val();
            if (branch_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        }


        if (chk == 3) {
            var zone_id = $('#zone_id').val();
            if (zone_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
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
                url: "ajax/user/Add.php",
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

    function setUserLevel(user_level) {
        if (user_level == 2 || user_level == 1) {
            $("#select_branch").show();
            $("#select_zone").hide();

        } else if (user_level == 3) {
            $("#select_zone").show();
            $("#select_branch").hide();
        } else {
            $("#select_branch").hide();
            $("#select_zone").hide();
        }
    }

    function ModalEdit(user_id) {
        $.ajax({
            type: "post",
            url: "ajax/user/ModalEdit.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });

                $('#chkbox').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                }).on('ifChanged', function(e) {
                    if ($('#chkbox').is(':checked') == true) {
                        $('#line_active').val('1');
                    } else {
                        $('#line_active').val('0');
                    }
                });
            }
        });
    }


    function choose_team(branch_id) {

        var user_level = $('#user_level_1').val();
        $.ajax({
            type: 'POST',
            url: "ajax/user/Getleader.php",
            dataType: "html",
            data: {
                branch_id: branch_id,
                user_level: user_level

            },
            success: function(response) {
                $("#select_leader").html(response);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }



    function Update() {

        var chk = $('#user_level_1').val();
        var username = $('#username').val();
        var fullname = $('#fullname').val();
        var mobile_phone = $('#mobile_phone').val();

        if (chk == "" || username == "" || fullname == "" || mobile_phone == "") {

            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;

        }

        if (chk == 1 || chk == 2) {
            var branch_id = $('#branch_id').val();
            if (branch_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        }


        if (chk == 3) {
            var zone_id = $('#zone_id').val();
            if (zone_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
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
                url: "ajax/user/Update.php",
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


    function Modal_view(user_id) {
        $.ajax({
            type: "post",
            url: "ajax/user/ModalView.php",
            data: {
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }

    function ChangeStatus(button, user_id) {
        $.ajax({
            type: "post",
            url: "ajax/user/ChangeStatus.php",
            data: {
                user_id: user_id
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