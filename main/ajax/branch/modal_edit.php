<?php
session_start();
include_once('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$branch_id = $_POST['branch_id'];

$sql = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
$rs = mysqli_query($connection, $sql) or die($connection->error);
$row = mysqli_fetch_assoc($rs);

$sql_dis = "SELECT * FROM tbl_district WHERE district_id = '{$row['district_id']}'";
$rs_dis = mysqli_query($connection, $sql_dis) or die($connection->error);
$row_dis = mysqli_fetch_assoc($rs_dis);

$sql_am = "SELECT * FROM tbl_amphoe WHERE amphoe_id = '{$row_dis['ref_amphoe']}'";
$rs_am = mysqli_query($connection, $sql_am) or die($connection->error);
$row_am = mysqli_fetch_assoc($rs_am);

$sql_ze = "SELECT * FROM tbl_zone WHERE zone_id = '{$row_ze['zone_id']}'";
$rs_ze = mysqli_query($connection, $sql_ze) or die($connection->error);
$row_ze = mysqli_fetch_assoc($rs_ze);

$ref_province = $row_am['ref_province'];
$ref_amphoe = $row_dis['ref_amphoe'];
$ref_zone = $row_ze['ref_zone'];

?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">เเก้ไขเพิ่มทีม/ศูนย์</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_color" method="POST" enctype="multipart/form-data">
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">


        <div class="row" style="margin-bottom:10px;">

            <div table class="col-md-12">

                <div class="row">

                <div class="col-6 md-4">
                        <div class="form-group">
                            <label>รหัสทีม</label>
                            <font color="red">**</font>
                            <input type="text" name="team_number" class="form-control" id="team_number" value="<?php echo $row['team_number'] ?>" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>ชื่อเพิ่มทีม/ศูนย์</label>
                            <font color="red">**</font>
                            <input type="text" name="branch_name" class="form-control" id="branch_name" value="<?php echo $row['branch_name'] ?>" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>ที่อยู่1</label>
                            <input type="text" name="address1" class="form-control" id="address1" value="<?php echo $row['address'] ?>" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>ที่อยู่2</label>
                            <input type="text" name="address2" class="form-control" id="address2" value="<?php echo $row['address2'] ?>" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-4">
                        <label>จังหวัด</label>
                        <font color="red">**</font><br>
                        <select class="form-control select2" name="province" id="province" onchange="GetAmphoeC(this.value)">

                            <option value="all">กรุณาระบุ</option>
                            <?php $sql_type = "SELECT * FROM tbl_province ORDER BY province_name_th";
                            $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                            while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

                                <option value="<?php echo $row_type['province_id'] ?>" <?php if ($row_type['province_id'] == $row_am['ref_province']) {
                                                                                            echo 'SELECTED';
                                                                                        } ?>><?php echo $row_type['province_name_th'] ?></option>

                            <?php } ?>


                        </select>
                    </div>

                    <div class="col-4" id="getamphoe">
                        <label>แขวง/อำเภอ</label>
                        <font color="red">**</font><br>
                        <select class="form-control select2" name="amphoe" id="amphoe">

                            <option value="all">กรุณาระบุ</option>
                            <?php $sql_type = "SELECT * FROM tbl_amphoe WHERE ref_province = '$ref_province'";
                            $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                            while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

                                <option value="<?php echo $row_type['amphoe_id'] ?>" <?php if ($row_type['amphoe_id'] == $row_am['amphoe_id']) {
                                                                                            echo 'SELECTED';
                                                                                        } ?>><?php echo $row_type['amphoe_name_th'] ?></option>

                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-4" id="getdistrict">
                        <label>เขต/ตำบล</label>
                        <font color="red">**</font><br>
                        <select class="form-control select2" name="district" id="district">

                            <option value="all">กรุณาระบุ</option>

                            <?php $sql_type = "SELECT * FROM tbl_district WHERE ref_amphoe = '$ref_amphoe'";
                            $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                            while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

                                <option value="<?php echo $row_type['district_id'] ?>" <?php if ($row_type['district_id'] == $row['district_id']) {
                                                                                            echo 'SELECTED';
                                                                                        } ?>><?php echo $row_type['district_name_th'] ?></option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="col-4" id="getzone">
                         <label>โซน</label>
                         <font color="red">**</font><br>
                         <select class="form-control select2" name="zone_id" id="zone_id">
                         
                         <option value="all">กรุณาระบุ</option>
                            <?php $sql_type = "SELECT * FROM tbl_zone WHERE active_status = 1 ORDER BY zone_id";
                            $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                            while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>
                            
                            <option value="<?php echo $row_type['zone_id'] ?>" <?php if ($row_type['zone_id'] == $row['zone_id']) {
                                                                                            echo 'SELECTED';
                                                                                        } ?>><?php echo $row_type['zone_name'] ?></option>

                            <?php } ?>


                        </select>
                    </div>
                </div>


            </div>


        </div>

    </div>
</form>

<?PHP include('import_script'); ?>

<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="btn_submit">ยืนยัน</button>
</div>



<script>
    $(document).ready(function() {

        $(".select2").select2({
            width: "100%"
        })

    });


    $('.chosen-select').chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });



    $('#btn_submit').on('click', function() {
        submit();
    })


    function GetAmphoeC(province_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/branch/getAmphoeC.php',
            data: {
                province_id: province_id,
            },
            dataType: 'html',
            success: function(response) {
                $('#getamphoe').html(response);
                $(".select2").select2({});
                GetDistrict(amphoe.value)
            }

        });

    }

    function GetDistrict(amphoe_id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/branch/getDistrict.php',
            data: {
                amphoe_id: amphoe_id,
            },
            dataType: 'html',
            success: function(response) {
                $('#getdistrict').html(response);
                $(".select2").select2({});

            }
        });
    }

  


    function submit() {

        var branch_name = $('#branch_name').val();
        var district = $('#district').val();



        var formData = new FormData($("#frm_color")[0]);

        if (branch_name == "" || district == "all") {
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
                url: 'ajax/branch/update.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                       
                        load_table();
                    }
                }
            })
        });
    }
</script>