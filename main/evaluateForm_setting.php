<meta http-equiv="pragma" content="no-cache" />
<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$sql_type = "SELECT * FROM tbl_product_type ORDER BY type_code";
$result_type  = mysqli_query($connection, $sql_type);




?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12" style="margin-left: 20px;">
        <h2>ตั้งค่าแบบประเมินความพึงพอใจ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าหลัก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="evaluateForm_setting.php">ตั้งค่าแบบประเมินความพึงพอใจ</a>
            </li>

        </ol>
    </div>
</div>


<div id="wrapper">
    <!-- <div id="page-wrapper" class="gray-bg"> -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="ibox">

                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-3">
                                <label>ประเภทงาน</label>
                                <select class="form-control select2" id="job_type" name="job_type">
                                    <option value="">กรุณาเลือกประเภทงาน</option>
                                    <option value="1">CM</option>
                                    <option value="2">PM</option>
                                    <option value="3">Installation</option>
                                    <option value="4">Overhaul</option>
                                    <option value="5">Other</option>
                                </select>
                            </div>

                            <!-- <div class="col-3">
                                <label>ประเภทเครื่อง</label>
                                <select class="form-control select2" id="product_type" name="product_type">
                                    <option value="">กรุณาเลือกประเภทเครื่อง</option>
                                    <?php while ($row_type = mysqli_fetch_array($result_type)) { ?>
                                    <option value="<?php echo $row_type['type_id'] ?>">
                                        <?php echo $row_type['type_code'] . " " . $row_type['type_name'] ?></option>
                                    <?php } ?>

                                </select>
                            </div> -->


                            <!-- <div class="col-3" id="oh_point">

                            </div> -->
                            <div id="kt_list_getTable" class="ms-auto">
                                <div class="col-3">
                                    <label><br></label><br>
                                    <button class="btn btn-xs btn-info" onclick="GetTable();">แสดงรายการ</button>
                                </div>
                            </div>
                            <div id="kt_list_submit" class="flex-row-fluid d-none">
                                <label><br></label><br>
                                <!-- <div class="d-flex"> -->

                                <button type="button" id="btn_list_submit" class="btn btn-xs btn-success "
                                    onclick="UpdateListOrder();">
                                    <span class="indicator-label ">บันทึก</span>
                                    <!-- <span class="indicator-progress">โปรดรอสักครู่...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span> -->
                                </button>
                                <button id="btn_list_cancel" type="button" class="btn btn-xs btn-light">ยกเลิก</button>
                                <!-- </div> -->
                            </div>
                            <div id="kt_list_order" class="ms-auto">
                                <label><br></label><br>
                                <button class="btn btn-xs btn-success" onclick="ListOrder();">
                                    เรียงลำดับ
                                </button>
                            </div>
                        </div>
                        <div class="ibox-tools">
                            <button class="btn btn-xs btn-success" onclick="Modal_Add();"><i class="fa fa-plus"></i>
                                เพิ่มแบบประเมิน</button>
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
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>
<script>
$(document).ready(function() {
    GetTable();
    $(".select2").select2({});

    var kt_list_order = document.getElementById("kt_list_order"),
        kt_list_submit = document.getElementById("kt_list_submit"),
        btn_list_cancel = document.getElementById("btn_list_cancel");
    kt_list_order.querySelector("button").addEventListener("click", function() {
            kt_list_order.classList.toggle("d-none");
            kt_list_submit.classList.toggle("d-none");
        }),
        btn_list_cancel.addEventListener("click", function() {
            kt_list_order.classList.toggle("d-none");
            kt_list_submit.classList.toggle("d-none");
            GetTable();
        });
});

function ListOrder() {
    $("#sortable").sortable({
        connectWith: ".connectList",
        update: function(event, ui) {
            $('.list_order').map(function(i, ele) {
                let index = i + 1;
                $(this).html(index);
            });
        }
    }).disableSelection();
}




function UpdateListOrder() {
    // const queryString = window.location.search;
    // const urlParams = new URLSearchParams(queryString);
    // var campaign_id = urlParams.get('id');

    // $("#btn_list_submit").attr('data-kt-indicator', 'on');
    $("#btn_list_submit").attr('disabled', true);

    let evaluate_id = $('#tbl_evaluate tbody tr').map((i, ele) => {
        return $(ele).attr('id').split('_')[1];
    }).get();

    $.ajax({
        type: "POST",
        dataType: "json",
        url: "ajax/evaluateForm_setting/UpdateListOrder.php",
        data: {
            // campaign_id: campaign_id,
            evaluate_id: evaluate_id
        },
        success: function(response) {
            // $("#btn_list_submit").removeAttr('data-kt-indicator');
            $("#btn_list_submit").attr('disabled', false);

            if (response.result == 1) {
                swal({
                    title: "",
                    text: "ดำเนินการสำเร็จ",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1000
                }, function() {
                    swal.close();
                    document.getElementById("kt_list_submit").classList.toggle("d-none");
                    document.getElementById("kt_list_order").classList.toggle("d-none");
                    GetTable();
                    $('#Loading').hide();
                });
            } else {
                swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
            }

        }
    });
}

function GetTable() {
    var job_type = $('#job_type').val();
    var product_type = $('#product_type').val();

    if (job_type == 4) {

        var oh_type = $('#oh_type').val();

        $.ajax({
            type: 'POST',
            url: "ajax/evaluateForm_setting/GetTable.php",
            data: {
                job_type: job_type,
                product_type: product_type,
                oh_type: oh_type
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });

    } else {
        $.ajax({
            type: 'POST',
            url: "ajax/evaluateForm_setting/GetTable.php",
            data: {
                job_type: job_type,
                product_type: product_type
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }
}





function Modal_Add() {
    var job_type = $('#job_type').val();
    // var product_type = $('#product_type').val();

    if (job_type == "") {
        swal("", "กรุณาเลือกประเภทงานและเครื่อง", "error");
        return false;
    }
    if (job_type == 4) {

        var oh_type = $('#oh_type').val();
        if (oh_type == "") {
            swal("", "กรุณาเลือกประเภทงาน OH", "error");
            return false;
        }



        $.ajax({
            type: "POST",
            url: "ajax/evaluateForm_setting/overhaul/ModalAdd.php",
            data: {
                job_type: job_type,
                oh_type: oh_type
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });

    } else {
        $.ajax({
            type: "POST",
            url: "ajax/evaluateForm_setting/ModalAdd.php",
            data: {
                job_type: job_type
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }
}



function ModalEdit(evaluate_id) {

    var job_type = $('#job_type').val();

    if (job_type == "") {
        swal("", "กรุณาเลือกประเภทงาน", "error");
        return false;
    }

    if (job_type != 4) {
        $.ajax({
            type: "POST",
            url: "ajax/evaluateForm_setting/ModalEdit.php",
            data: {
                evaluate_id: evaluate_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    } else {
        $.ajax({
            type: "POST",
            url: "ajax/evaluateForm_setting/overhaul/ModalEdit.php",
            data: {
                evaluate_id: evaluate_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }
}



function Update() {

    var form_name = $("#form_name").val();
    var form_type = $("#form_type").val();
    var choice1 = $("#choice1").val();
    var choice2 = $("#choice2").val();


    if (form_name == "" || form_type == "" || choice1 == "" || choice2 == "") {
        swal("", "ไม่สามารถทำรายการ กรุณากรอกข้อมูลให้ครบถ้วน", "error");
        return false;
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
            url: "ajax/evaluateForm_setting/Update.php",
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



function Add() {



    var form_name = $("#form_name").val();
    var form_type = $("#form_type").val();
    var choice1 = $("#choice1").val();
    var choice2 = $("#choice2").val();


    if (form_name == "" || form_type == "" || choice1 == "" || choice2 == "") {
        swal("", "ไม่สามารถทำรายการ กรุณากรอกข้อมูลให้ครบถ้วน", "error");
        return false;
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
            url: "ajax/evaluateForm_setting/Add.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
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
                        $("#modal").modal('hide');
                        $('#Loading').hide();
                    });
                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });

    });




}



// function Add_oh() {



//     var form_name = $("#form_name").val();
//     var form_type = $("#form_type").val();
//     var oh_type = $("#oh_type").val();
//     var choice1 = $("#choice1").val();
//     var choice2 = $("#choice2").val();


//     if (form_name == "" || oh_type == "" || form_type == '') {
//         swal("", "ไม่สามารถทำรายการ กรุณากรอกข้อมูลให้ครบถ้วน", "error");
//         return false;
//     }
//     if (form_type != 3) {
//         if (choice1 == "" || choice2 == "") {
//             swal("", "ไม่สามารถทำรายการ กรุณากรอกข้อมูลให้ครบถ้วน", "error");
//             return false;
//         }
//     }

//     swal({
//         title: "",
//         text: "กรุณายืนยันการทำรายการ",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#00FF00",
//         confirmButtonText: "ยืนยัน",
//         cancelButtonColor: "#DD6B55",
//         cancelButtonText: "ยกเลิก",
//         closeOnConfirm: false
//     }, function() {

//         let myForm = document.getElementById('form-add');
//         let formData = new FormData(myForm);

//         $.ajax({
//             type: "POST",
//             dataType: "json",
//             url: "ajax/evaluateForm_setting/overhaul/Add.php",
//             data: formData,
//             cache: false,
//             contentType: false,
//             processData: false,
//             success: function(response) {


//                 if (response.result == 1) {
//                     swal({
//                         title: "",
//                         text: "ดำเนินการสำเร็จ",
//                         type: "success",
//                         showConfirmButton: false,
//                         timer: 1000
//                     }, function() {
//                         swal.close();
//                         GetTable();
//                         $("#modal").modal('hide');
//                         $('#Loading').hide();
//                     });
//                 } else {
//                     swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
//                 }

//             }
//         });

//     });




// }


// function Update_oh() {

//     var form_name = $("#form_name").val();
//     var oh_type = $("#oh_type").val();
//     var choice1 = $("#choice1").val();
//     var choice2 = $("#choice2").val();


//     if (form_name == "" || oh_type == "" || choice1 == "" || choice2 == "") {
//         swal("", "ไม่สามารถทำรายการ กรุณากรอกข้อมูลให้ครบถ้วน", "error");
//         return false;
//     }

//     swal({
//         title: "",
//         text: "กรุณายืนยันการทำรายการ",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#00FF00",
//         confirmButtonText: "ยืนยัน",
//         cancelButtonColor: "#DD6B55",
//         cancelButtonText: "ยกเลิก",
//         closeOnConfirm: false
//     }, function() {

//         let myForm = document.getElementById('form-edit');
//         let formData = new FormData(myForm);

//         $.ajax({
//             type: "POST",
//             dataType: "json",
//             url: "ajax/evaluateForm_setting/overhaul/Update.php",
//             data: formData,
//             cache: false,
//             contentType: false,
//             processData: false,
//             success: function(response) {

//                 console.log(response);

//                 if (response.result == 1) {
//                     swal({
//                         title: "",
//                         text: "ดำเนินการสำเร็จ",
//                         type: "success",
//                         showConfirmButton: false,
//                         timer: 1000
//                     }, function() {
//                         swal.close();
//                         GetTable();
//                         $("#modal").modal('hide');
//                     });
//                 } else {
//                     swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
//                 }

//             }
//         });

//     });
// }
</script>