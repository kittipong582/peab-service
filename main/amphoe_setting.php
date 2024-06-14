<meta http-equiv="pragma" content="no-cache" />
<?php include('header.php');
session_start();
include_once('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12" style="margin-left: 20px;">
        <h2>ตั้งค่าอำเภอ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าหลัก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="amphoe_setting.php">ตั้งค่าอำเภอ</a>
            </li>

        </ol>
    </div>
</div>

<div id="wrapper">
    <!-- <div id="page-wrapper" class="gray-bg"> -->
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <label>ตั้งค่าอำเภอ</label>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-4">
                                <label>จังหวัด</label>
                                <select class="form-control select2" name="province" id="province" onchange="GetAmphoeC(this.value),get_branch(this.value)">

                                    <option value="">ทั้งหมด</option>
                                    <?php $sql_type = "SELECT * FROM tbl_province ORDER BY province_name_th";
                                    $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
                                    while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

                                        <option value="<?php echo $row_type['province_id'] ?>"><?php echo $row_type['province_name_th'] ?></option>

                                    <?php } ?>


                                </select>
                            </div>

                            <div class="col-3" id="get_branch">


                            </div>
                            <div class="col-2">

                            </div>
                            <div class="col-3">

                            </div>

                        </div>
                        <br>
                        <div class="row" id="get_amphoe">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?PHP include('import_script'); ?>

<script>
    $(document).ready(function() {

        $(".select2").select2({
            width: "100%"
        })


    });

    function GetAmphoeC(province_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/amphoe/getAmphoeC.php',
            data: {
                province_id: province_id,
            },
            dataType: 'html',
            success: function(response) {
                $('#get_amphoe').html(response);
                $(".select2").select2({});
            }

        });

    }

    function get_branch(province_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/amphoe/get_branch.php',
            data: {
                province_id: province_id
            },
            dataType: 'html',
            success: function(response) {
                $('#get_branch').html(response);
                $(".select2").select2({});
            }

        });

    }

    function save_amphoe(branch_id) {

        var province = $('#province').val();

        var formData = new FormData($("#frm_color")[0]);

        if (branch_id == "" || province == "all") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'ajax/amphoe/save_province.php',
            data: {
                province: province,
                branch_id: branch_id
            },
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
                    GetAmphoeC(province);
                    $('.modal-backdrop').remove()

                }
            }
        })

    }


    function save_amphoe1(branch_id, amphoe_id) {

        var province = $('#province').val();
        var formData = new FormData($("#frm_color")[0]);

        if (branch_id == "" || amphoe_id == "all") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'ajax/amphoe/save_amphoe.php',
            data: {
                amphoe_id: amphoe_id,
                branch_id: branch_id,
            },
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
                    get_branch(data.province);
                    $('.modal-backdrop').remove()

                }
            }
        })

    }
</script>