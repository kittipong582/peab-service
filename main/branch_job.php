<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="job_list.php">รายการงาน</a>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="row">
        <?php include('ajax/menu/branch_customer_menu.php'); ?>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

                        <input type="hidden" id="customer_branch_id" name="customer_branch_id" value="<?php echo $customer_branch_id ?>">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ค้นหาโดย</label>
                                        <select class="form-control select2" id="search_status" name="search_status" data-width="100%">
                                            <option value="1">วันที่นัดหมาย </option>
                                            <option value="2" selected>วันที่ทำรายการ </option>
                                            <option value="3">วันที่ดำเนินการ </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>ตั้งแต่</label>

                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
                                    </div>

                                </div>

                                <div class="col-md-2">
                                    <label> ถึงวันที่</label>
                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>">
                                    </div>

                                </div>


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ชนิดงาน</label>
                                        <select class="form-control select2" id="job_type" name="job_type" data-width="100%">
                                            <option value="x" selected>ทั้งหมด </option>
                                            <option value="1">CM </option>
                                            <option value="2">PM </option>
                                            <option value="3">Installation </option>
                                            <option value="4">Overhaul </option>
                                            <option value="5">งานอื่นๆ </option>
                                            <option value="6">งานเสนอราคา </option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <br>
                                    <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox" value="chkbox">
                                    <input type="hidden" id="insurance_status" name="insurance_status" value="0" style="position: absolute; opacity: 0;">
                                    <label>ไม่ระบุช่วงเวลา</label>
                                    <!-- <div class="form-group">
                                        <label>ทีมงาน</label>
                                        <select class="form-control select2" id="branch" name="branch" data-width="100%"
                                            onchange="GetUser2(this.value)">
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
                                    </div> -->
                                </div>



                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                                </div>


                                <!-- <div class="col-md-1">
                                </div> -->

                                <!-- <div class="col-lg-1">
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
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="show_modal"></div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        $(document).ready(function() {
            GetTable();

            $('#chkbox').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            }).on('ifChanged', function(e) {
                if ($('#chkbox').is(':checked') == true) {
                    $('#insurance_status').val('1');
                } else {
                    $('#insurance_status').val('0');
                }
            });
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

        function GetTable() {

            var search_status = $("#search_status").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var customer_branch_id = $("#customer_branch_id").val();
            var job_type = $("#job_type").val();
            var insurance_status = $("#insurance_status").val();

            $.ajax({
                type: 'POST',
                url: "ajax/branch_job/GetTable.php",
                data: {
                    search_status: search_status,
                    start_date: start_date,
                    end_date: end_date,
                    insurance_status: insurance_status,
                    job_type: job_type,
                    customer_branch_id: customer_branch_id
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true,
                        "ordering": false,
                    });
                    $('#Loading').hide();
                }
            });
        }


        function DeleteJob(job_id, type) {




            if (job_id == "" || type == "") {
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
                    url: 'ajax/branch_job/Delete.php',
                    data: {
                        job_id: job_id,
                        type: type
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == 1) {
                            swal({
                                title: "ดำเนินการสำเร็จ!",
                                text: "ทำการลบรายการ เรียบร้อย",
                                type: "success",
                                showConfirmButton: true
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        } else if (data.result == 0) {
                            swal({
                                title: 'ผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่ !!',
                                type: 'warning'
                            });
                            return false;
                        }else if (data.result == 2) {
                            swal({
                                title: 'ผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลบ้างส่วนได้ กรุณาติดต่อเจ้าหน้าที่ !!',
                                type: 'warning'
                            });
                            return false;
                        }else  {
                            swal({
                                title: 'ผิดพลาด!',
                                text: 'กรุณาติดต่อเจ้าหน้าที่ !!',
                                type: 'warning'
                            });
                            return false;
                        }

                    }
                })

            });



        }
    </script>