<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_GET['id'];

$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

// echo $row['job_type'];

?>
<style>
    .box-input {
        min-height: 90px;
    }

    .modal-dialog {
        max-width: 1000px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>เเก้ไขงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>เเก้ไขงาน</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <form action="" method="POST" id="form_edit_job" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
                    <input type="hidden" id="job_type" name="job_type" value="<?php echo $row['job_type'] ?>">
                    <div class="ibox-title">
                        <strong><b><?php echo $row['job_no'] ?></b></strong>
                    </div>

                    <div class="ibox-content" id="form_edit">



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

        var job_type = $('#job_type').val();

        job_form(job_type);

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


        // $("search_text_customer").keypress(function(event) {

        //     console.log(event);
        //     if (event.keyCode == 13) {

        //         console.log("11111111");
        //         if ($("#search_text_customer").val() != "") {
        //             // Search();
        //             // console.log("etsfsd");
        //             test();
        //         }
        //     }
        // });


    });







    function job_form(job_type) {

        var job_id = $('#job_id').val();

        if (job_type == 1) {

            $.ajax({
                type: 'POST',
                url: 'ajax/job/CM/Form_Edit.php',
                data: {
                    job_id: job_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#form_edit').html(response);
                    $(".select2").select2({});
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });


                }
            });

        } else if (job_type == 2) {
            $.ajax({
                type: 'POST',
                url: 'ajax/job/PM/Form_Edit.php',
                data: {
                    job_id: job_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#form_edit').html(response);
                    $(".select2").select2({});
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });


                }
            });
        } else if (job_type == 3) {
            $.ajax({
                type: 'POST',
                url: 'ajax/job/IN/Form_Edit.php',
                data: {
                    job_id: job_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#form_edit').html(response);
                    $(".select2").select2({});
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });


                }
            });
        } else if (job_type == 4) {
            $.ajax({
                type: 'POST',
                url: 'ajax/job/job_overhaul/Form_Edit.php',
                data: {
                    job_id: job_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#form_edit').html(response);
                    $(".select2").select2({});
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });


                }
            });
        } else if (job_type == 5) {


            $.ajax({
                type: 'POST',
                url: 'ajax/job/Other/Form_Edit.php',
                data: {
                    job_id: job_id
                },
                dataType: 'html',
                success: function(response) {
                    $('#form_edit').html(response);
                    $(".select2").select2({});
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
                    $(".datepicker").datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                    });


                }
            });

        } else if (job_type == 6) {

            $.ajax({
                type: 'POST',
                url: 'ajax/job/quotation/Form_Edit.php',
                data: {
                    job_id: job_id
                },
                dataType: 'html',
                success: function(response) {

                    $('#form_edit').html(response);
                    $(".select2").select2({});
                    $('.summernote').summernote({
                        toolbar: false,
                        height: 100,
                    });
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



    function Other_care() {
        $.ajax({
            type: "post",
            url: "ajax/job/CM/ModalOther_Care.php",
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


    function option_overhaul() {

        $.ajax({
            url: 'ajax/job/Add_row_service.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment
            },
            success: function(data) {
                $('#Addform').html(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });

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

    function Cal(quantity, i) {
        var unit_cost = $('#unit_cost_' + i).val();
        var cost_price = parseFloat(quantity) * parseFloat(unit_cost) || 0;
        $('#unit_price_' + i).val(cost_price);

    }


    function desty(i) {
        document.getElementById('tr_' + i).remove();
    }

    function desty_staff(i) {
        document.getElementById('row_staff_' + i).remove();

    }
    /////////////////////CM///////////////////


    function Update_job() {

        var job_type = $('#job_type').val();
        var appointment_date = $('#appointment_date').val();
        var job_id = $('#job_id').val();
        var customer_branch_id = $('#customer_branch_id').val();
        var product_id = $('#product_id').val();
        var job_id = $('#job_id').val();
        var formData = new FormData($("#form_edit_job")[0]);

        if (job_type != 6 && job_type != 5) {
            if (product_id == "" || customer_branch_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ข้อมูลสาขากับเครื่องไม่ตรงกัน กรุณาตรวจสอบ',
                    type: 'error'
                });
                return false;
            }
        }

        if (job_type == 6) {
            var total = $('#last_total').val();
            if (total == "" || total <= 0) {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ราคารวมสุทธิไม่ถูกต้อง กรุณาตรวจสอบ',
                    type: 'error'
                });
                return false;
            }
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
                url: 'ajax/job/Check_editdate.php',
                data: {
                    appointment_date: appointment_date,
                    job_id: job_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.check_result == 1) {
                        swal({
                            title: 'มีงานอ้างอิงของงาน จำนวนนี้ ' + data.check_num + ' งาน',
                            text: 'ดำเนินการต่อหรือไม่',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'ยกเลิก',
                            confirmButtonText: 'ยืนยัน',
                            closeOnConfirm: false
                        }, function() {
                            if (job_type == 1) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax/job/CM/update_cm.php',
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
                                            window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                            } else if (job_type == 2) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax/job/PM/update_pm.php',
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
                            } else if (job_type == 3) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax/job/IN/update_in.php',
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
                                            window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                            } else if (job_type == 4) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax/job/job_overhaul/update_oh.php',
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
                                            window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                            } else if (job_type == 5) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax/job/Other/update_oth.php',
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
                                            window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                            } else if (job_type == 6) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax/job/quotation/update_qt.php',
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
                                            window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                            }
                        });
                    } else {

                        if (job_type == 1) {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/job/CM/update_cm.php',
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
                                        window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                        } else if (job_type == 2) {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/job/PM/update_pm.php',
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
                                        window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                        } else if (job_type == 3) {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/job/IN/update_in.php',
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
                                        window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                        } else if (job_type == 4) {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/job/job_overhaul/update_oh.php',
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
                                        window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                        } else if (job_type == 5) {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/job/Other/update_oth.php',
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
                                        window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                        } else if (job_type == 6) {
                            $.ajax({
                                type: 'POST',
                                url: 'ajax/job/quotation/update_qt.php',
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
                                        window.location.href = 'view_cm.php?id=' + job_id + '&&type=1';
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
                        }
                    }
                }

            });
        });
    }



    function add_row_list() {
        $('#counter').html(function(i, val) {
            return +val + 1

        });
        var increment = $('#counter').html();

        $.ajax({
            url: 'ajax/job/quotation/Add_row_list.php',
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

    function Cal_Qs(i) {
        var unit_cost = $('#unit_' + i).val();
        var quantity = $('#quantity_' + i).val();
        var cost_price = parseFloat(quantity) * parseFloat(unit_cost) || 0;
        $('#unit_price_' + i).val(cost_price);
        cal_total();
    }


    function cal_total() {

        var final = 0;

        $(".unit_price").each(function() {
            final += parseFloat($(this).val() || 0);

        });

        $("#total").val(final);

        cal_discount();
    }


    function cal_discount() {

        var total = $("#total").val();
        var discounts = $("#discounts").val();

        var final = parseFloat(total || 0) - parseFloat(discounts || 0);

        $('#after_discounts').val(final);
        cal_last_total();

    }


    function cal_last_total() {


        var last_total = $('#after_discounts').val();

        $('#last_total').val(last_total);
    }


    function customer_type(type) {



        if (type == 2) {

            $('#type_box').hide();
            $('#type_search').hide();
            $('#part1').hide();
            $('#customer_name').val('');
            $('#branch_name').val('');
            $('#customer_branch_id').val('');
            $('#contact_name').val('');
            $('#contact_position').val('');
            $('#contact_phone').val('');
            $('#branch_care_id').val('');
            $('#branch_care').val('');
            $('#searchqt_box').val('');


        } else {
            $('#part1').show();
            $('#type_box').show();
            $('#type_search').show();
        }

    }


    function desty_list(i) {
        document.getElementById('tr_' + i).remove();
        Cal_Qs(i);
    }


    function get_oh_product(branch_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/CM/overhaul/GetDDoverhual.php",
            data: {
                branch_id: branch_id,
            },
            dataType: "html",
            success: function(response) {
                $("#overhaul_point").html(response);
                $(".select2").select2({});

                $("#o_product_type").val('');
                $("#o_serial_no").val('');
                $("#o_model").val('');
                $("#o_brand").val('');
                $("#o_type").val('');

                $("#o_warranty_start_date").val('');
                $("#o_warranty_expire_date").val('');
            }
        });
    }


    function select_overhaul(overhaul_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/job_overhaul/GetOverhaul.php",
            data: {
                overhaul_id: overhaul_id
            },
            dataType: "json",
            success: function(response) {
                $("#o_product_type").val(response.product_type);
                $("#o_serial_no").val(response.serial_no);
                $("#o_model").val(response.model_name);
                $("#o_brand").val(response.brand_name);
                $("#o_type").val(response.product_type);

                $("#o_warranty_start_date").val(response.warranty_start_date);
                $("#o_warranty_expire_date").val(response.warranty_expire_date);

            }
        });
    }



    function Choose_customer_edit(customer_id) {
        $("#modal").modal('hide');
        // var customer_id = $('#customer_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/job/Edit/form_branch.php",
            data: {
                customer_id: customer_id
            },
            dataType: "html",
            success: function(response) {
                $("#point_branch").html(response);
                $(".select2").select2({});
                $("#product_id").val('');
                $("#serial_no").val('');
                $("#product_type").val('');
                $("#brand").val('');
                $("#model").val('');
                $("#warranty_type").val('');
                $("#install_date").val('');
                $("#warranty_start_date").val('');
                $("#warranty_expire_date").val('');
                $("#customer_branch_id").val('');
            }
        });


    }



    function Get_detailProduct(product_id) {


        $.ajax({
            type: "POST",
            url: "ajax/job/Edit/Get_Detail_Product.php",
            data: {
                product_id: product_id
            },
            dataType: "json",
            success: function(response) {
                $("#product_id").val(response.product_id);
                $("#serial_no").val(response.serial_no);
                $("#product_type").val(response.product_type);
                $("#brand").val(response.brand);
                $("#model").val(response.model);

                $("#warranty_type").val(response.warranty_type);
                $("#install_date").val(response.install_date);
                $("#warranty_start_date").val(response.warranty_start_date);
                $("#warranty_expire_date").val(response.warranty_expire_date);

            }
        });




    }


    function Get_customer_branch(customer_branch_id) {


        // $("#customer_branch_id").val(customer_branch_id);

        $.ajax({
            type: "POST",
            url: "ajax/job/Edit/Get_customer_branch.php",
            data: {
                customer_branch_id: customer_branch_id
            },
            dataType: "json",
            success: function(response) {
                $("#branch_name").val(response.branch_name);
                $("#contact_name").val(response.contact_name);
                $("#contact_position").val(response.contact_position);
                $("#contact_phone").val(response.contact_phone);
                $("#customer_branch_id").val(customer_branch_id);
                $("#product_id").val('');
                get_product();
            }
        });


    }



    function add_product_row() {
        $('#product_counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#product_counter').html();
        $.ajax({
            url: 'ajax/job/IN/add_row_product.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment
            },
            success: function(data) {

                $('#add_product_row').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }




    function get_product() {

        var customer_branch_id = $('#customer_branch_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/job/Edit/get_product_detail.php",
            data: {
                customer_branch_id: customer_branch_id
            },
            dataType: "html",
            success: function(response) {
                $("#product_point").html(response);
                $(".select2").select2({});
            }
        });

    }


    function Modal_get_customer() {

        var search_text_customer = $('#search_text_customer').val();
        var search_type = $('#search_type').val();


        if (search_type == "" || search_text_customer == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
        $.ajax({
            type: "post",
            url: "ajax/job/Edit/Modal_get_customer.php",
            data: {
                search_text_customer: search_text_customer,
                search_type: search_type
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


    function Get_oh_return(branch_id) {

        $.ajax({
            url: 'ajax/CM_view/sub_oh/get_user_return.php',
            type: 'POST',
            dataType: 'html',
            data: {
                branch_id: branch_id,

            },
            success: function(response) {
                // console.log(data.text);
                $('#return_user_point').html(response);
                $(".select2").select2({});
            }
        });
    }

    function setModel(brand_id, i) {

        $.ajax({
            type: 'POST',
            url: 'ajax/job/IN/getModel.php',
            data: {
                brand_id: brand_id,
                i: i,
            },
            dataType: 'html',
            success: function(response) {
                $('#getmodel_' + i).html(response);
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


    function Other_care_IN() {
        $.ajax({
            type: "post",
            url: "ajax/job/IN/ModalOther_Care.php",
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



    function search_product(i) {

        var product_id = $('#serial_no_' + i).val();
        var customer_branch_id = $('#customer_branch_id').val();
        $.ajax({
            type: 'POST',
            url: 'ajax/job/IN/check_product.php',
            data: {
                i: i,
                product_id: product_id,
                customer_branch_id: customer_branch_id
            },
            dataType: 'json',
            success: function(data) {
                if (data.result == 1) {
                    swal({
                        title: "ตรวจพบสินค้า!",
                        text: "ทำดึงข้อมูล เรียบร้อย",
                        type: "success",
                    });
                    setTimeout(function() {
                        swal.close();
                    }, 1000);
                    $("#btn_ref_" + i).removeClass("btn-warning");
                    $("#btn_ref_" + i).addClass("btn-primary");
                    get_product_data(data.product_id, i);
                    $("#product_id_" + i).val(data.product_id);
                } else {
                    swal({
                        title: 'ผิดพลาด!',
                        text: 'ไม่พบข้อมูลสินค้า กรุณาทำรายการใหม่!!',
                        type: 'warning'
                    });

                    document.getElementById('row_product_' + i).remove();

                    return false;

                }

            }
        })

    }


    function get_product_data(product_id, i) {


        $.ajax({
            type: 'POST',
            url: 'ajax/job/IN/get_product_data.php',
            data: {
                product_id: product_id
            },
            dataType: 'json',
            success: function(data) {
                /////////////////2.///////////////////
                $("#point_type_" + i).html(data.product_type);
                $("#point_model_" + i).html(data.model);
                $("#point_brand_" + i).html(data.brand);
                $("#point_war_type_" + i).html(data.warranty_type);
                $("#warranty_start_date_" + i).val(data.warranty_start_date);
                $("#install_date_" + i).val(data.install_date);
                $("#warranty_expire_date_" + i).val(data.warranty_expire_date);

            }
        })


    }


    function desty_list(i) {
        document.getElementById('tr_' + i).remove();
        Cal_Qs(i);
    }


    function desty_staff(i) {
        document.getElementById('row_staff_' + i).remove();

    }

    function desty_product(i) {
        document.getElementById('row_product_' + i).remove();

    }


    function Searchqt() {
        var search_box = $('#searchqt_box').val();
        var search_type = $('#search_type').val();

        if (search_box == "" || search_type == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาใส่ข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "ajax/job/quotation/ModalSearch.php",
                data: {
                    search_box: search_box,
                    search_type: search_type
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
</script>