<?php
include('header.php');
include("../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_GET['id'];

////////////////////////////edit

$sql = "SELECT * FROM tbl_customer_branch WHERE customer_branch_id = '$customer_branch_id'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);


// $sql_detail = "SELECT * FROM tbl_customer a JOIN tbl_customer_branch b ON a.customer_id = b.customer_id WHERE a.customer_id = '$customer_id'";
// $result_detail  = mysqli_query($connection, $sql_detail);
// $row_detail = mysqli_fetch_array($result_detail);

////////////////////address
$sql_address = "SELECT a.district_id,a.district_zipcode,b.amphoe_id,c.province_id,a.ref_amphoe FROM tbl_district a 
LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
LEFT JOIN tbl_province c ON b.ref_province = c.province_id
 WHERE a.district_id = '{$row['district_id']}'";
$rs_address = mysqli_query($connection, $sql_address);
$row_address = mysqli_fetch_array($rs_address);


///////////////////////////team
$list_branch = array();

$sql_branch = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$rs_branch = mysqli_query($connection, $sql_branch);
while ($row_branch = mysqli_fetch_array($rs_branch)) {

    $temp_array_branch = array(
        "branch_id" => $row_branch['branch_id'],
        "branch_name" => $row_branch['branch_name'],
    );

    array_push($list_branch, $temp_array_branch);
}

// ///////////////////////contact
// $sql_contact = "SELECT * FROM tbl_customer_contact WHERE customer_branch_id = '{$row['customer_branch_id']}'";
// $result_contact  = mysqli_query($connection, $sql_contact);
// $row_contact = mysqli_fetch_array($result_contact);

?>
<style>
    .box-input {
        height: 90px;
    }

    .select2-container .select2-selection--single {
        height: 35.59px;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 0px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px;
        right: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>แก้ไขสาขาลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_branch_list.php">ข้อมูลสาขา</a>
            </li>
            <li class="breadcrumb-item ">
                <a href="branch_view_detail.php?id=<?php echo $customer_branch_id ?>">
                    <?php echo $row['branch_name'] ?>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <strong>แก้ไขสาขาลูกค้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <?php include('ajax/menu/branch_customer_menu.php'); ?>
    <form action="" method="post" id="form_edit_branch" enctype="multipart/form-data">
        <input type="hidden" id="customer_branch_id" name="customer_branch_id"
            value="<?php echo $customer_branch_id ?>">
        <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $row['customer_id'] ?>">

        <div class="ibox">
            <div class="ibox-title">
                <h5>ข้อมูลลูกค้า</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-3 col-12 box-input">
                        <label for="">ค้นหาจาก</label>
                        <select class="form-control select2" id="search_type" name="search_type">
                            <option value="1">ชื่อลูกค้า</option>
                            <option value="2">รหัสลูกค้า</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">คำค้นหา</label>
                        <div class="input-group">
                            <input type="textbox" class="form-control" id="search_text" name="search_text">
                            <span class="input-group-append"><button type="button" id="btn_search" name="btn_search"
                                    onclick="search_customer()" class="btn btn-primary">ค้นหา</button></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 box-input" id="customer_point">

                    </div>

                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <h5>ข้อมูลสาขา</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6 col-12 box-input">
                        <label for="">ชื่อสาขา (ชื่อร้าน)<font class="text-danger">*</font></label>
                        <input type="text" class="form-control" value="<?php echo $row['branch_name'] ?>"
                            name="branch_name" id="branch_name">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสสาขา</label>
                        <input type="text" class="form-control" value="<?php echo $row['branch_code'] ?>"
                            name="branch_code" id="branch_code">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัส AX </label>
                        <input type="text" class="form-control" value="<?php echo $row['ax_code'] ?>" name="ax_code"
                            id="ax_code">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสสาขาทางภาษี </label>
                        <input type="text" class="form-control" value="<?php echo $row['tax_branch_code'] ?>"
                            name="tax_branch_code" id="tax_branch_code">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">ประเภทลูกค้า <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="billing_type" id="billing_type">
                            <option value="">โปรดระบุ</option>
                            <option value="1" <?php echo ($row['billing_type'] == 1) ? 'selected' : ''; ?>>นิติบุคคล
                            </option>
                            <option value="2" <?php echo ($row['billing_type'] == 2) ? 'selected' : ''; ?>>บุคคลธรรมดา
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">ชื่อสำหรับออกใบกำกับภาษี <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" value="<?php echo $row['billing_name'] ?>"
                            name="branch_invoice_name" id="branch_invoice_name">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">เลขประจำตัวผู้เสียภาษี</label>
                        <input type="text" class="form-control" value="<?php echo $row['billing_tax_no'] ?>"
                            name="branch_tax_no" id="branch_tax_no">
                    </div>

                    <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่สำหรับออกใบกำกับภาษี</label>
                        <input type="text" class="form-control" value="<?php echo $row['billing_address'] ?>"
                            name="branch_invoice_address" id="branch_invoice_address">
                    </div>



                    <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่ร้านค้า</label>
                        <input type="text" class="form-control" value="<?php echo $row['address'] ?>" name="address"
                            id="address">
                    </div>


                    <div class="col-md-3 col-12 box-input">
                        <label for="">จังหวัด <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="province_id" id="province_id"
                            onchange="get_amphoe(this.value);">
                            <option value="">โปรดระบุ</option>
                            <?php
                            $sql_province = "SELECT * FROM tbl_province  ORDER BY province_name_th ASC";
                            $rs_province = mysqli_query($connection, $sql_province);
                            while ($row_province = mysqli_fetch_array($rs_province)) { ?>
                                <option value="<?php echo $row_province['province_id']; ?>" <?php echo ($row_address['province_id'] == $row_province['province_id']) ? 'selected' : ''; ?>>
                                    <?php echo $row_province['province_name_th']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input" id="amphoe_div">
                        <label for="">อำเภอ/เขต <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="amphoe_id" id="amphoe_id"
                            onchange="get_district(this.value);">
                            <option value="">โปรดระบุ</option>
                            <?php
                            $sql_amphoe = "SELECT * FROM tbl_amphoe WHERE ref_province = '{$row_address['province_id']}'  ORDER BY amphoe_name_th ASC";
                            $rs_amphoe = mysqli_query($connection, $sql_amphoe);
                            while ($row_amphoe = mysqli_fetch_array($rs_amphoe)) { ?>
                                <option value="<?php echo $row_amphoe['amphoe_id']; ?>" <?php echo ($row_address['amphoe_id'] == $row_amphoe['amphoe_id']) ? 'selected' : ''; ?>>
                                    <?php echo $row_amphoe['amphoe_name_th']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input" id="district_div">
                        <label for="">ตำบล/แขวง <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="district_id" id="district_id"
                            onchange="get_zipcode(this.value)">
                            <option value="">โปรดระบุ</option>
                            <?php
                            $sql_district = "SELECT * FROM tbl_district WHERE ref_amphoe = '{$row_address['amphoe_id']}'  ORDER BY district_name_th ASC";
                            $rs_district = mysqli_query($connection, $sql_district);
                            while ($row_district = mysqli_fetch_array($rs_district)) { ?>
                                <option value="<?php echo $row_district['district_id']; ?>" <?php echo ($row_address['district_id'] == $row_district['district_id']) ? 'selected' : ''; ?>>
                                    <?php echo $row_district['district_name_th']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสไปรษณีย์</label>
                        <input type="text" class="form-control" value="<?php echo $row_address['district_zipcode'] ?>"
                            name="district_zipcode" id="district_zipcode" readonly>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ทีมงานที่ดูแล <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="branch_care_id" id="branch_care_id">
                            <option value="">โปรดระบุ</option>
                            <?php foreach ($list_branch as $data_branch) { ?>
                                <option value="<?php echo $data_branch['branch_id']; ?>" <?php echo ($row['branch_id'] == $data_branch['branch_id']) ? 'selected' : ''; ?>>
                                    <?php echo $data_branch['branch_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 col-12 box-input">
                        <label for="">Google Map Link</label>
                        <input type="text" class="form-control" value="<?php echo $row['google_map_link']; ?>"
                            name="google_map_link" id="google_map_link">
                    </div>


                    <div class="col-md-2 col-12 box-input">
                        <label><br></label>
                        <br>
                        <label> <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox"
                                value="chkbox"> ใช้ที่อยู่เดียวกับลูกค้า</label>

                    </div>


                </div>
            </div>
       
        </div>



    </form>

    <div class="text-center">
        <button class="btn btn-primary px-5" type="button" onclick="Submit()">
            บันทึกข้อมูลลูกค้า
        </button>
    </div>

</div>

<?php include('footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $(".select2").select2({
            width: '100%'
        });

        // get_amphoe();
    });



    $('#chkbox').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    }).on('ifChanged', function (e) {
        var customer_id = $('#customer_id').val();


        if ($('#chkbox').is(':checked') == true) {
            $.ajax({
                type: 'POST',
                url: "ajax/customer_branch/get_tax_detail.php",
                data: {
                    customer_id: customer_id
                },
                dataType: "json",
                success: function (data) {
                    $('#branch_invoice_address').val(data.billing_address);
                    $('#branch_invoice_name').val(data.billing_name);
                    $('#branch_tax_no').val(data.billing_tax_no);

                }
            });

        } else {
            $('#branch_invoice_address').val('');
            $('#branch_invoice_name').val('');
            $('#branch_tax_no').val('');
        }
    });


    $("#code_alert").hide();

    function get_amphoe(ref_province) {


        $.ajax({
            type: 'POST',
            url: "ajax/customer_branch/get_amphoe.php",
            data: {
                ref_province: ref_province
            },
            dataType: "html",
            success: function (response) {
                $("#amphoe_div").html(response);

                $(".select2").select2({
                    width: '100%'
                });
                get_district();

            }
        });
    };


    function get_district(ref_amphoe) {

        $.ajax({
            type: 'POST',
            url: "ajax/customer_branch/get_district.php",
            data: {
                ref_amphoe: ref_amphoe
            },
            dataType: "html",
            success: function (response) {
                $("#district_div").html(response);
                $(".select2").select2({
                    width: '100%'
                });

            }
        });
    };


    function get_zipcode(district_id) {

        $.ajax({
            type: 'POST',
            url: "ajax/customer_branch/get_zipcode.php",
            data: {
                district_id: district_id
            },
            dataType: "json",
            success: function (data) {
                $("#district_zipcode").val(data.zipcode);
                $(".select2").select2({
                    width: '100%'
                });

            }
        });

    };


    function search_customer() {

        var search_type = $('#search_type').val();
        var search_text = $('#search_text').val();

        if (search_text == "") {

            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;

        }
        $.ajax({
            type: 'POST',
            url: "ajax/customer_branch/get_customer.php",
            data: {
                search_text: search_text,
                search_type: search_type
            },
            dataType: "html",
            success: function (response) {
                $("#customer_point").html(response);
                $(".select2").select2({
                    width: '100%'
                });

            }
        });




    }




    function Submit() {

        var formData = new FormData($("#form_edit_branch")[0]);

        const branch_name = $("#branch_name").val();
        const branch_code = $("#branch_code").val();
        const billing_type = $("#billing_type").val();
        const address = $("#address").val();
        const address2 = $("#address2").val();
        const province_id = $("#province_id").val();
        const amphoe_id = $("#amphoe_id").val();
        const district_id = $("#district_id").val();
        const district_zipcode = $("#district_zipcode").val();
        const branch_care_id = $("#branch_care_id").val();
        const google_map_link = $("#google_map_link").val();



        if (branch_name == "" || billing_type == "" || district_zipcode == "" || branch_care_id == "") {
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
        }, function () {

            $.ajax({
                type: 'POST',
                url: 'ajax/customer_branch/Update.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                        setTimeout(() => {
                            location.href = "branch_view_detail.php?id=" + data.customer_id;
                        }, 3000);
                    } else if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อสาขาซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;

                    }

                }
            })
        });

    }
</script>