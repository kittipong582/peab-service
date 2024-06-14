<?php include('header.php');
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_GET['id'];

$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_customer_branch b on a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
LEFT JOIN tbl_customer_contact d ON b.customer_branch_id = d.customer_branch_id
LEFT JOIN tbl_product e ON e.product_id = a.product_id
LEFT JOIN tbl_branch f ON b.branch_care_id = f.branch_id
 WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

// echo $sql;

if ($row['product_type'] == 1) {
    $product_type = 'เครื่องชง';
} else if ($row['product_type'] == 2) {
    $product_type = 'เครื่องบด';
} else if ($row['product_type'] == 3) {
    $product_type = 'เครื่องปั่น';
}

$brand_id = $row['brand_id'];
$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$model_id = $row['model_id'];
$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);

if ($row['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}

if ($row['install_date'] != null) {
    $install = date("d-m-Y", strtotime($row['install_date']));
} else {
    $install = "-";
}

if ($row['warranty_start_date'] != null) {
    $warranty_start_date = date("d-m-Y", strtotime($row['warranty_start_date']));
} else {
    $warranty_start_date = "-";
}

if ($row['warranty_expire_date'] == null) {
    $warranty = "-";
} else {

    $now = strtotime("today");
    $expire_date = strtotime($row['warranty_expire_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain < 0) {
        $total_remain = "หมดอายุ " . abs($days_remain) . " วัน";
    } else {
        $total_remain = "เหลือ " . $days_remain . " วัน";
    }
    $warranty = date("d-m-Y", strtotime($row['warranty_expire_date'])) . " ( " . $total_remain . " )";
}

?>
<style>
    .box-input {
        min-height: 90px;
    }

    .modal-dialog {
        max-width: 1200px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>เพิ่มงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>เพิ่มงาน</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <form action="" method="POST" id="form_add_job" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">

                        <div class="row">

                            <div class="col-4 mb-3">
                                <strong>ประเภทงานย่อย</strong>
                                <font color="red">**</font><br>
                                <select name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" class="form-control select2 mb-3 ">
                                    <option value="">กรุณาเลือก</option>
                                    <?php $sql_sub = "SELECT * FROM tbl_sub_job_type WHERE job_type = '2'";
                                    $result_sub  = mysqli_query($connect_db, $sql_sub);
                                    while ($row_sub = mysqli_fetch_array($result_sub)) { ?>
                                        <option value="<?php echo $row_sub['sub_job_type_id'] ?>"><?php echo $row_sub['sub_type_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb-3">

                            <input type="hidden" name="job_type" id="job_type" style="width: 100%;" value="2">
                            <input type="hidden" name="ref_job" id="ref_job" style="width: 100%;" value="<?php echo $job_id ?>">
                            <input type="hidden" name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" value="<?php echo '5'; ?>">


                            <div class="mb-3 col-12">
                                <strong>
                                    <h4>1.ข้อมูลลูกค้า</h4>
                                </strong>
                            </div>
                            <div class="mb-3 col-3">
                                <label>ชื่อลูกค้า</label>
                                <input type="text" readonly id="customer_name" value="<?php echo $row['customer_name'] ?>" name="customer_name" class="form-control">
                            </div>
                            <div class="mb-3 col-3">
                                <label>ชื่อร้าน</label>
                                <input type="text" readonly id="branch_name" value="<?php echo $row['branch_name'] ?>" name="branch_name" class="form-control">
                            </div>
                            <div class="mb-3 col-3">
                                <label>งานที่เกี่ยวข้อง</label>
                                <div class="input-group">
                                    <input type="text" id="" name="" value="" class="form-control">
                                    <span class="input-group-append"><button type="button" id="btn_ref" name="btn_ref" class="btn btn-primary">งานที่เกี่ยวข้อง</button></span>
                                </div>
                            </div>

                            <div class="mb-3 col-3">
                                <label>งานอ้างอิง</label>
                                <div class="input-group">
                                    <input type="text" id="job_ref" readonly name="job_ref" value="<?php echo $row['job_no'] ?>" class="form-control">
                                </div>
                            </div>

                            <input type="hidden" id="customer_branch_id" value="<?php echo $row['customer_branch_id'] ?>" name="customer_branch_id">
                            <div class="mb-3 col-3">
                                <label>ผู้ติดต่อ</label>
                                <font color="red">**</font>
                                <input type="text" id="contact_name" value="<?php echo $row['contact_name'] ?>" name="contact_name" class="form-control">
                            </div>

                            <div class="mb-3 col-3">
                                <label>ตำแหน่ง</label>

                                <input type="text" id="contact_position" value="<?php echo $row['contact_position'] ?>" name="contact_position" class="form-control">
                            </div>

                            <div class="mb-3 col-3">
                                <label>เบอร์โทรติดต่อ</label>
                                <font color="red">**</font>
                                <div class="input-group">
                                    <input type="text" id="contact_phone" value="<?php echo $row['contact_phone'] ?>" name="contact_phone" class="form-control">
                                    <span class="input-group-append"><button type="button" onclick="other_contact();" id="btn_ref" name="btn_ref" class="btn btn-primary">เลือกผู้ติดต่ออื่น</button></span>
                                </div>

                            </div>


                        </div>

                        <div class="row mb-3">
                            <input type="hidden" id="choose_product_id" value="<?php echo $row['product_id'] ?>" name="choose_product_id">
                            <div class="mb-3 col-12">
                                <strong>
                                    <h4>2.ข้อมูลสินค้า</h4>
                                </strong>
                            </div>
                            <?php if ($row['product_id'] != null) { ?>
                                <div class="mb-3 col-3">
                                    <label>Serial No</label>
                                    <input type="text" readonly id="serial_no" value="<?php echo $row['serial_no'] ?>" name="serial_no" class="form-control">
                                </div>
                                <div class="mb-3 col-3">
                                    <label>ประเภทเครื่อง</label>
                                    <input type="text" readonly id="product_type" value="<?php echo $product_type ?>" name="product_type" class="form-control">
                                </div>
                                <div class="mb-3 col-3">
                                    <label>ยี่ห้อ</label>
                                    <input type="text" readonly id="brand" value="<?php echo $row_brand['brand_name'] ?>" name="brand" class="form-control">
                                </div>
                                <div class="mb-3 col-3">
                                    <label>รุ่น</label>
                                    <input type="text" readonly id="model" value="<?php echo $row_model['model_name'] ?>" name="model" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>ประเภทการรับประกัน</label>
                                    <input type="text" readonly id="warranty_type" value="<?php echo $warranty_text ?>" name="warranty_type" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>วันที่ติดตั้ง</label>
                                    <input type="text" readonly id="install_date" value="<?php echo $install ?>" name="install_date" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>วันที่เริ่มประกัน</label>
                                    <input type="text" readonly id="warranty_start_date" value="<?php echo $warranty_start_date ?>" name="warranty_start_date" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>วันที่หมดประกัน</label>
                                    <input type="text" readonly id="warranty_expire_date" value="<?php echo $warranty ?>" name="warranty_expire_date" class="form-control">
                                </div>

                            <?php } else {

                                $sql_product = "SELECT a.*,b.*,c.brand_name,d.model_name FROM tbl_in_product a
                                LEFT JOIN tbl_product b ON a.product_id = b.product_id 
                                LEFT JOIN tbl_product_brand c ON b.brand_id = c.brand_id
                                LEFT JOIN tbl_product_model d ON b.model_id = d.model_id
                                WHERE a.job_id = '$job_id'";

                                // echo $sql_product;
                                $result_product  = mysqli_query($connect_db, $sql_product);
                            ?>
                                <div class="mb-3 col-12">
                                    <select class="select2" id="product_choice" onchange="get_product_inpm(this.value)" name="product_choice">
                                        <option value="">กรุณาเลือกเครื่อง</option>
                                        <?php while ($row_product = mysqli_fetch_array($result_product)) { ?>
                                            <option value="<?php echo $row_product['product_id'] ?>"><?php echo $row_product['serial_no'] . " - " . $row_product['brand_name'] . " - " . $row_product['model_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-3">
                                    <label>Serial No</label>
                                    <input type="text" readonly id="serial_no" value="<?php echo $row_product['serial_no'] ?>" name="serial_no" class="form-control">
                                </div>
                                <div class="mb-3 col-3">
                                    <label>ประเภทเครื่อง</label>
                                    <input type="text" readonly id="product_type" value="<?php echo $product_type ?>" name="product_type" class="form-control">
                                </div>
                                <div class="mb-3 col-3">
                                    <label>ยี่ห้อ</label>
                                    <input type="text" readonly id="brand" value="<?php echo $row_product['brand_name'] ?>" name="brand" class="form-control">
                                </div>
                                <div class="mb-3 col-3">
                                    <label>รุ่น</label>
                                    <input type="text" readonly id="model" value="<?php echo $row_product['model_name'] ?>" name="model" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>ประเภทการรับประกัน</label>
                                    <input type="text" readonly id="warranty_type" value="<?php echo $warranty_text ?>" name="warranty_type" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>วันที่ติดตั้ง</label>
                                    <input type="text" readonly id="install_date" value="<?php echo $install ?>" name="install_date" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>วันที่เริ่มประกัน</label>
                                    <input type="text" readonly id="warranty_start_date" value="<?php echo $warranty_start_date ?>" name="warranty_start_date" class="form-control">
                                </div>

                                <div class="mb-3 col-3">
                                    <label>วันที่หมดประกัน</label>
                                    <input type="text" readonly id="warranty_expire_date" value="<?php echo $warranty ?>" name="warranty_expire_date" class="form-control">
                                </div>

                                <hr width="95%">

                            <?php
                            }
                            ?>
                        </div>

                        <div class="row mb-3">

                            <div class="mb-3 col-12">
                                <strong>
                                    <h4>3.แผนงาน</h4>
                                </strong>
                            </div>

                            <div class="mb-3 col-12">

                                <input type="hidden" readonly id="current_branch_care" value="<?php echo $row['branch_id'] ?>" name="current_branch_care" class="form-control branch_care_id">

                                <div class="text-left mb-3">
                                    <div class="from-group">
                                        <button class="btn btn-sm btn-outline-primary" type="button" onclick="addPMForm()">
                                            <i class="fa fa-plus"></i> เพิ่มแผนงาน
                                        </button>

                                        <button class="btn btn-sm btn-outline-info" type="button" id="helpbtn" onclick="addHelpForm()">
                                            ตัวช่วยการเลือก
                                        </button>
                                    </div>
                                </div>

                                <div id="form_help" style="display: none;">
                                    <input type="hidden" id="check_help" name="check_help" value="0">
                                    <div class="row">
                                        <div class="mb-3 col-3">
                                            <label>วันที่</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" id="start_help_date" name="start_help_date" class="form-control datepicker" readonly value="<?php echo date('d-m-Y', strtotime($row['appointment_date'] .  "+ 3 months")) ?>" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="mb-3 col-3">
                                            <label>จำนวนครั้ง</label>
                                            <div class="input-group">
                                                <input type="text" id="plan_times" name="plan_times" class="form-control ">
                                            </div>
                                        </div>

                                        <div class="mb-3 col-3">
                                            <label>ระยะห่าง (วัน)</label>

                                            <input type="text" id="distance_date" name="distance_date" class="form-control">
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label></label><br>
                                            <button class="btn btn-sm btn-primary" type="button" onclick="create_plan()">
                                                สร้างแผนงาน
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div id="PMcounter" hidden>1</div>

                                <div id="form_contact"></div>
                                <hr>

                            </div>

                        </div>


                        <div class="row mb-3">
                            <div class="mb-3 col-12">
                                <strong>
                                    <h4>4.ค่าบริการ</h4>
                                </strong>
                            </div>

                            <div class="mb-3 col-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;"></th>
                                            <th style="width:20%;">รายการ</th>
                                            <th style="width:10%;">จำนวน</th>
                                            <th style="width:10%;">หน่วย</th>
                                            <th style="width:10%;">ราคาต่อหน่วย</th>
                                            <th style="width:10%;">ราคารวม (โดยประมาณ)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Addform" name="Addform">
                                        <div id="counter" hidden>0</div>

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row();"><i class="fa fa-plus"></i>
                                    เพิ่มรายการ
                                </button>
                            </div>



                        </div>

                        <div class="row mb-3">
                            <div class="mb-3 col-12">
                                <strong>
                                    <h4>5.หมายเหตุ</h4>
                                </strong>
                            </div>
                            <div class="mb-3 col-12">

                                <textarea type="text" id="note" value="" name="note" class="summernote"></textarea>
                            </div>

                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_PM()">บันทึก</button>
                        </div>

                    </div>

                </div>


            </div>

        </div>
    </form>

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

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        $(".select2").select2({});


        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });


    });


    function other_contact() {

        var customer_branch_id = $('#customer_branch_id').val();

        if (customer_branch_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาใส่ข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "ajax/job/ModalOther_Contact.php",
                data: {
                    customer_branch_id: customer_branch_id
                },
                dataType: "html",
                success: function(response) {
                    $("#modal .modal-content").html(response);
                    $("#modal").modal('show');
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".select2").select2({});
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });
                }
            });
        }
    }

    function add_row() {

        $('#counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#counter').html();
        $.ajax({
            url: 'ajax/job/Add_row_service.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment
            },
            success: function(data) {

                $('#Addform').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }

    function select_Service(service_id, i) {

        var quantity = $('#quantity_' + i).val();
        $.ajax({
            url: 'ajax/job/Get_service.php',
            type: 'POST',
            dataType: 'json',
            data: {
                service_id: service_id,
            },
            success: function(data) {

                $('#unit_' + i).val(data.unit);
                $('#unit_cost_' + i).val(data.unit_cost);
                var cost_price = parseFloat(quantity) * parseFloat(data.unit_cost) || 0;

                $('#unit_price_' + i).val(cost_price);


            }
        });
    }

    function get_product_inpm(product_id) {

        $.ajax({
            url: 'ajax/job/Get_Product_impm.php',
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: product_id,
            },
            success: function(data) {

                $('#serial_no').val(data.serial_no);
                $('#product_type').val(data.product_type);
                $('#brand').val(data.brand);
                $('#model').val(data.model);
                $('#warranty_type').val(data.warranty_type);
                $('#install_date').val(data.install_date);
                $('#warranty_start_date').val(data.warranty_start_date);
                $('#warranty_expire_date').val(data.warranty_expire_date);
                $('#choose_product_id').val(data.product_id);

            }
        });
    }



    function Cal(quantity, i) {
        var unit_cost = $('#unit_cost_' + i).val();
        var cost_price = parseFloat(quantity) * parseFloat(unit_cost) || 0;
        $('#unit_price_' + i).val(cost_price);

    }


    function desty(i) {
        document.getElementById('tr_' + i).remove();
    }




    function addHelpForm() {

        var check_help = $('#check_help').val();


        if (check_help == 0) {

            $('#form_help').show();

            $('#check_help').val(1);

            $('#helpbtn').addClass("active");
        } else {

            $('#form_help').hide();

            $('#check_help').val(0);

            $('#helpbtn').removeClass("active");

        }


    }

    function addPMForm() {

        var branch_id = $('#current_branch_care').val();
        var row = $('#PMcounter').html();
        var date = $('#appointment_date_' + row).val();
        $('.new_pm_multi_form').remove();
        $('#PMcounter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#PMcounter').html();


        $('#form_help').hide();
        $('#check_help').val(0);
        $('#helpbtn').removeClass("active");

        $.ajax({
            type: 'POST',
            url: "ajax/job/INPM/addPMForm.php",
            dataType: "html",
            data: {
                Count_Row: increment,
                check_plan: branch_id,
            },
            success: function(response) {

                $("#form_contact").append(response);
                $(".delete-contact").click(function(e) {
                    $(this).parents('.new_pm_form').remove();
                    $('#PMcounter').html(function(i, val) {
                        return +val - 1
                    });
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $.ajax({
                    type: "POST",
                    url: "ajax/job/INPM/GetSelectPM_User.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#user_list_" + increment).html(response);
                        $(".select2").select2({});
                    }
                });
                // const [day, month, year] = date.split('-');

                // var new_date = [month, day, year].join('-');
                // new_date = new Date(new_date.replace(/-/g, '/'));
                // new_date.setDate(new_date.getDate() + 30); // Set now + 30 days as the new date
                // new_date = new_date.toLocaleDateString();

                // const [m, d, y] = new_date.split('/');
                // var last_date = [d, m, y].join('-');
                // $("#appointment_date_" + increment).val(last_date);




            }
        });
    }



    function create_plan() {

        var branch_id = $('#current_branch_care').val();
        $('#PMcounter').html(1);
        var PMcounter = parseInt(1);
        var plan_times = parseInt($('#plan_times').val());
        var start_help_date = $('#start_help_date').val();
        var distance_date = $('#distance_date').val();
        $('.new_pm_form').remove();
        $('.new_pm_multi_form').remove();
        var row = (PMcounter + plan_times);



        $.ajax({
            type: 'POST',
            url: "ajax/job/INPM/addPM_MultiForm.php",
            dataType: "html",
            data: {
                Count_Row: PMcounter,
                start_help_date: start_help_date,
                distance_date: distance_date,
                plan_times: plan_times,
                row: row,
                check_plan: branch_id,

            },
            success: function(response) {

                $("#form_contact").append(response);
                $('#PMcounter').html(function(i, val) {
                    return +val + plan_times
                });
                $(".delete-contact").click(function(e) {
                    $(this).parents('.new_pm_multi_form').remove();
                    $('#PMcounter').html(function(i, val) {
                        return +val - 1
                    });
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                for (let i = 0; i < row; i++) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/job/INPM/GetSelectPM_User.php",
                        data: {
                            branch_id: branch_id,
                        },
                        dataType: "html",
                        success: function(response) {
                            $("#user_list_" + i).html(response);
                            $(".select2").select2({});
                        }
                    });

                }

            }
        });
    }





    function Other_care_PM(row) {
        $.ajax({
            type: "post",
            url: "ajax/job/INPM/ModalOther_Care.php",
            data: {
                row: row,
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });

    }


    function get_date(date, row) {

        const [day, month, year] = date.split('-');

        var new_date = [month, day, year].join('-');
        new_date = new Date(new_date.replace(/-/g, '/'));
        new_date.setDate(new_date.getDate() + 30); // Set now + 30 days as the new date
        new_date = new_date.toLocaleDateString();

        const [m, d, y] = new_date.split('/');
        var last_date = [d, m, y].join('-');
        row = Number(row) + 1;
        // $("#appointment_date_" + row).val(last_date);

    }



    function check_job_pm(date, row) {

        var customer_branch_id = $('#customer_branch_id').val();
        $.ajax({
            url: 'ajax/job/INPM/Check_Pm_job.php',
            type: 'POST',
            dataType: 'json',
            data: {
                date: date,
                customer_branch_id: customer_branch_id
            },
            success: function(data) {

                $('#alert_text_' + row).html(data.alert_text);

            }
        });



    }

    function get_Pm_care(branch_id, i) {

        $.ajax({
            type: "POST",
            url: "ajax/job/INPM/GetSelect_PM_User.php",
            data: {
                branch_id: branch_id,
            },
            dataType: "html",
            success: function(response) {
                $("#user_care_" + i).html(response);
                $(".select2").select2({});
            }
        });
    }


    function Submit_PM() {

        var job_type = $('#job_type').val();
        var customer_branch_id = $('#customer_branch_id').val();
        var contact_name = $('#contact_name').val();
        var contact_position = $('#contact_position').val();
        var contact_phone = $('#contact_phone').val();
        var product_id = $('#choose_product_id').val();
        var appointment_date = $('#appointment_date_1').val();
        var sub_job_type_id = $('#sub_job_type_id').val();

        var row = $('#PMcounter').html();

        var formData = new FormData($("#form_add_job")[0]);

        if (job_type == "" || customer_branch_id == "" || row == 1 || sub_job_type_id == "" || contact_name == "" || contact_phone == "" || product_id == "" || appointment_date == "") {
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
                url: 'ajax/job/INPM/Add_PM.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                        window.location.href = 'job_list.php';
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>