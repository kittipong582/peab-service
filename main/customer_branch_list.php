<?php
include('header.php');
include("../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลสาขา</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ข้อมูลสาขา</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
            <div class="row">
                
                <div class="col-3">
                    <div class="form-group">
                        <label>ค้นหาด้วย</label>
                        <select class="form-control select2" id="search_type" name="search_type" data-width="100%">
                            <option value="1" >รหัสสาขา </option>
                            <option value="2" >ชื่อสาขา </option>
                            <option value="3" >รหัสลูกค้า </option>
                            <option value="4" >ชื่อลูกค้า </option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>คำค้นหา</label>
                        <input type="text" class="form-control " id="name_branch" name="name_branch" data-width="100%">


                    </div>
                </div>
                <div class="col-1">
                  
                </div>
                <div class="col-2">
                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                    <div class="form-group">
                        <input class="btn btn-xs btn-info btn-block" data-width="70%" type="button" onclick="GetTable();" value="แสดงข้อมูล">

                    </div>
                </div>
                <div class="col-2 text-center">
                    <a href="branch_form_new.php" data-width="70%" class="btn btn-xs btn-info"><i class="fa fa-plus"></i> เพิ่มสาขาลูกค้า</a>
                </div>
            </div>
        </div>
        <div class="ibox-content" id="show_data">

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

        $(".select2").select2({
            width: "75%"
        });
    });

    function GetTable() {

        var search_type = $('#search_type').val();
        var name_branch = $('#name_branch').val();

        $.ajax({
            type: 'POST',
            url: "ajax/customer_branch/GetTable.php",
            data: {
                search_type: search_type,
                name_branch: name_branch
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }
</script>