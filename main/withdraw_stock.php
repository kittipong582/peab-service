<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ตัด Stock</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="withdraw_stock.php">ตัด Stock</a>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<!-- <input type="hidden" name="customer_branch_id" id="customer_branch_id" value="<?php echo $customer_branch_id ?>"> -->

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
                                        <select class="form-control select2" id="spare_type" name="spare_type"
                                            data-width="100%" onchange="GetPart(this.value)">
                                            <option value="x" selected>ทั้งหมด </option>

                                            <?php 
                                                        
                                                        $sql_st = "SELECT spare_type_id,spare_type_name  FROM tbl_spare_type ;";
                                                        $rs_st = mysqli_query($connection, $sql_st);
                                                        while($row_st = mysqli_fetch_assoc($rs_st)){
                                                        
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
                                        <select class="form-control select2" id="spare_part" name="spare_part"
                                            data-width="100%">
                                            <option value="x" selected>ทั้งหมด </option>

                                            <?php 
                                                        
                                                        $sql_b = "SELECT spare_part_id,spare_part_name  FROM tbl_spare_part ;";
                                                        $rs_b = mysqli_query($connection, $sql_b);
                                                        while($row_b = mysqli_fetch_assoc($rs_b)){
                                                        
                                                        ?>

                                            <option value="<?php echo $row_b['spare_part_id'] ?>">
                                                <?php echo $row_b['spare_part_name'] ?></option>


                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>สาขา</label>
                                        <select class="form-control select2" id="branch" name="branch" data-width="100%"
                                            onchange="GetUser2(this.value)">
                                            <option value="x" selected>ทั้งหมด </option>

                                            <?php 
                                                        
                                                        $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                                        $rs_b = mysqli_query($connection, $sql_b);
                                                        while($row_b = mysqli_fetch_assoc($rs_b)){
                                                        
                                                        ?>

                                            <option value="<?php echo $row_b['branch_id'] ?>">
                                                <?php echo $row_b['branch_name'] ?></option>


                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2" id="get_user">
                                    <div class="form-group">
                                        <label>ทีมงาน</label>
                                        <select class="form-control select2" id="user" name="user" data-width="100%">
                                            <option value="x" selected>ทั้งหมด </option>

                                            <?php 
                                                        
                                                        $sql_u = "SELECT user_id,fullname FROM tbl_user ;";
                                                        $rs_u = mysqli_query($connection, $sql_u);
                                                        while($row_u = mysqli_fetch_assoc($rs_u)){
                                                        
                                                        ?>

                                            <option value="<?php echo $row_u['user_id'] ?>">
                                                <?php echo $row_u['fullname'] ?></option>


                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();"
                                        value="แสดงข้อมูล">
                                </div>


                                <div class="col-md-1">
                                </div>

                                <div class="col-lg-1" style="padding: 0px 0px 0px 0px;">
                                    <div class="form-group text-right">
                                        <a href="new_withdraw.php" class="btn btn-outline-primary btn-sm">นำออก</a>
                                    </div>

                                </div>

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
                        <div id="show_data"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    function GetUser2(branch_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/withdraw_stock/GetUser2.php',
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
            url: 'ajax/withdraw_stock/GetPart.php',
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

        var spare_part = $("#spare_part").val();
        var spare_type = $("#spare_type").val();
        var branch = $("#branch").val();
        var user = $("#user").val();

        $.ajax({
            type: 'POST',
            url: "ajax/withdraw_stock/GetTable.php",
            data: {
                spare_part: spare_part,
                spare_type: spare_type,
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
    </script>