<?php
session_start();
include_once('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">เพิ่มทีม/ศูนย์</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_color" method="POST" enctype="multipart/form-data">
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="branch_id" value="<?php echo getRandomID(10, 'tbl_branch', 'branch_id'); ?>">


        <div class="row" style="margin-bottom:10px;">

            <div table class="col-md-12">

                <div class="row">

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>รหัสทีม</label>
                            <font color="red">**</font>
                            <input type="text" name="team_number" class="form-control" id="team_number" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>ชื่อทีม/ศูนย์</label>
                            <font color="red">**</font>
                            <input type="text" name="branch_name" class="form-control" id="branch_name" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>ที่อยู่1</label>
                            <input type="text" name="address1" class="form-control" id="address1" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-6 md-4">
                        <div class="form-group">
                            <label>ที่อยู่2</label>
                            <input type="text" name="address2" class="form-control" id="address2" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-4 md-4">
                        <div class="form-group">
                            <label>จังหวัด</label>
                            <font color="red">**</font><br>
                            <select class="form-control select2" name="province" id="province" onchange="GetAmphoeC(this.value)">

                                <option value="all">กรุณาระบุ</option>
                                <?php $sql_type = "SELECT * FROM tbl_province ORDER BY province_name_th";
                                $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                                while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

                                    <option value="<?php echo $row_type['province_id'] ?>"><?php echo $row_type['province_name_th'] ?></option>

                                <?php } ?>


                            </select>
                        </div>
                    </div>

                    <div class="col-4 md-4" id="getamphoe">
                        <div class="form-group">
                            <label>แขวง/อำเภอ</label>
                            <font color="red">**</font><br>
                            <select class="form-control select2" name="amphoe" id="amphoe">

                                <option value="all">กรุณาระบุ</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-4 md-4" id="getdistrict">
                        <div class="form-group">
                            <label>เขต/ตำบล</label>
                            <font color="red">**</font><br>
                            <select class="form-control select2" name="district" id="district">

                                <option value="all">กรุณาระบุ</option>


                            </select>
                        </div>
                    </div>


                    <div class="col-4 md-4">
                        <div class="form-group">
                            <label>โซน </label>
                            <font color="red">**</font><br>
                            <select class="form-control select2" name="zone_id" id="zone_id">

                                <option value="">ไม่ระบุ</option>
                                <?php $sql_type = "SELECT * FROM tbl_zone WHERE active_status = 1 ORDER BY zone_name";
                                $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                                while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

                                    <option value="<?php echo $row_type['zone_id'] ?>"><?php echo $row_type['zone_name'] ?></option>

                                <?php } ?>


                            </select>
                        </div>
                    </div>




                </div>


            </div>


        </div>

    </div>
</form>

<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="btn_submit">ยืนยัน</button>
</div>
<?PHP include('import_script'); ?>


<script>
    $(document).ready(function() {

        $(".select2").select2({
            width: "100%"
        })


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



  
</script>