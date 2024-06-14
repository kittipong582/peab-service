<?php
session_start();
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ตั้งค่าอะไหล่เริ่มต้น</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="on_hand.php">ตั้งค่าอะไหล่เริ่มต้น</a>
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
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ประเภทอะไหล่</label>
                                        <select class="form-control select2" id="spare_type" name="spare_type" data-width="100%" onchange="GetPart(this.value)">
                                            <option value="x" selected>ทั้งหมด </option>
                                            <?php

                                            $sql_st = "SELECT spare_type_id,spare_type_name  FROM tbl_spare_type ;";
                                            $rs_st = mysqli_query($connect_db, $sql_st);
                                            while ($row_st = mysqli_fetch_assoc($rs_st)) {

                                            ?>

                                                <option value="<?php echo $row_st['spare_type_id'] ?>">
                                                    <?php echo $row_st['spare_type_name'] ?></option>


                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2" id="get_part">
                                    <div class="form-group">
                                        <label>ชนิดอะไหล่</label>
                                        <select class="form-control select2" id="spare_part" name="spare_part" data-width="100%">
                                            <option value="x" selected>ทั้งหมด </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ทีม</label>
                                        <select class="form-control select2" id="branch" name="branch" data-width="100%" onchange="GetUser(this.value)">
                                            <?php if ($user_level == '2' ){
                                                $sql_b = "SELECT a.branch_id,a.branch_name 
                                                FROM tbl_branch a LEFT JOIN tbl_user b 
                                                ON a.branch_id=b.branch_id
                                                WHERE b.user_id = '$user_id';";
                                                $rs_b = mysqli_query($connect_db, $sql_b);
                                                $row_b = mysqli_fetch_assoc($rs_b)
                                                ?>
                                                    <option value="<?php echo $row_b['branch_id'] ?>">
                                                    <?php echo $row_b['branch_name'] ?></option>
                                                <?php } else { ?>
        
                                            <option value="x" selected>ทั้งหมด </option>

                                            <?php

                                            $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                            $rs_b = mysqli_query($connect_db, $sql_b);
                                            while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                            ?>

                                                <option value="<?php echo $row_b['branch_id'] ?>">
                                                    <?php echo $row_b['branch_name'] ?></option>


                                            <?php }} ?>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-success btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="ModalAdd();" value="เพิ่มรายการ">
                                </div>

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
        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {
        // GetTable();
    });

    $(".datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        format: 'dd/mm/yyyy',
        thaiyear: false,
        language: 'th', //Set เป็นปี พ.ศ.
        autoclose: true
    });


    $(".select2").select2({
        width: "75%"
    });

    $('.summernote').summernote({
        toolbar: false,
        height: 100,
    });

    function GetUser(branch_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/on_hand/GetUser.php',
            data: {
                branch_id: branch_id
            },
            dataType: 'html',
            success: function(response) {
                $('#get_user').html(response);
                $("#user").select2();

            }
        });

    }

    function GetPart(spare_type_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/on_hand/GetPart.php',
            data: {
                spare_type_id: spare_type_id
            },
            dataType: 'html',
            success: function(response) {
                $('#get_part').html(response);
                $("#spare_part").select2();

            }
        });

    }

    function GetTable() {

        var spare_type = $("#spare_type").val();
        var spare_part = $("#spare_part").val();
        var branch = $("#branch").val();
        var user = $("#user").val();

        $.ajax({
            type: 'POST',
            url: "ajax/branch_stock_setting/GetTable.php",
            data: {
                spare_type: spare_type,
                spare_part: spare_part,
                branch: branch,
                user: user
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true,
                    // sorting: disable
                });
                $('#Loading').hide();
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            type: "POST",
            url: "ajax/branch_stock_setting/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
            }
        });
    }

    function ModalEdit(branch_id,spare_part_id) {
        $.ajax({
            type: "POST",
            url: "ajax/branch_stock_setting/ModalEdit.php",
            data: {
                branch_id: branch_id,
                spare_part_id: spare_part_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
            }
        });
    }

    function Delete(branch_id,spare_part_id) {
        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5564",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/branch_stock_setting/Delete.php",
                data: {
                    branch_id: branch_id,
                    spare_part_id: spare_part_id
                },
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
                        });
                    } else if(response.result == 0) {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                }
            });

        });
    }

    function Add() {

        var branch = $('#branch_id').val();
        var ax = $('#ax').val();
        var quantity = $('#quantity').val();

        var formData = new FormData($("#frm_import")[0]);

        if (branch == "x" || ax == "x" || quantity == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: 'ajax/branch_stock_setting/Insert.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.result == '1') {
                        swal.close();
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                        };
                        toastr.success('เพิ่มการตั้งค่ารายการใหม่แล้ว ', 'ดำเนินการเสร็จสิ้น');
                        ModalAdd();
                        GetTable();
                        
                    } else if (response.result == '2') {
                        swal({
                            title: '',
                            text: 'มีการตั้งค่ารายการนี้แล้ว ไม่สามารถทำรายการซ้ำได้กรุณาลองใหม่อีกครั้ง',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                }
            })

        });
    }

</script>