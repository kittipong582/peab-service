<?php

session_start();
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
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
                    </div>
                    <div class="ibox-content">
                        <div class="row mb-3">
                            <div class="col-md-3 col-4 box-input">
                                <strong>ประเภทงาน</strong>
                                <font color="red">**</font><br>
                                <select name="job_type" id="job_type" style="width: 100%;" class="form-control select2 mb-3 " onchange="job_form(this.value)">
                                    <option value="">กรุณาเลือกประเภท</option>
                                    <option value="1" <?php echo ($_GET['job_type'] == '1') ? "selected" : ""; ?>>CM</option>
                                    <option value="2">PM</option>
                                    <option value="3">Installation</option>
                                    <option value="4">OverHaul</option>
                                    <option value="5">งานอื่นๆ</option>
                                    <option value="6">ใบเสนอราคา</option>
                                    <option value="7">Audit</option>
                                </select>

                            </div>
                            <div class="col-mb-3 col-8 box-input" id="from_add">
                            </div>
                        </div>
                        <div class="ibox-content" id="form">

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

        $('#search_box').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                Search();
            }
        });

        $('#btn_search').on('click', function() {
            Search();

        });

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const job_type = urlParams.get('job_type');
        if (job_type == 1) { // ค่า get = 1 = งาน CM รับงานมาจาก QC
            job_form(job_type)

        }
    });

    function job_form(job_type) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const sn = urlParams.get('sn');
        const job = urlParams.get('job');

        $.ajax({
            type: 'POST',
            url: 'ajax/job/get_form_add.php',
            data: {
                job_type: job_type,
                sn: sn,
                st: job_type
            },
            dataType: 'html',
            success: function(response) {
                $('#from_add').html(response);
                $(".select2").select2({});
                if (job_type == 1) {
                    $.ajax({
                        url: 'ajax/job/CM/Form_CM_qc.php',
                        dataType: 'html',
                        success: function(response) {
                            $('#form').html(response);
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
                            if (job == 'qc') {
                                Search();
                            }
                        }
                    });
                } else if (job_type == 2) {
                    $.ajax({
                        url: 'ajax/job/PM/Form_PM.php',
                        dataType: 'html',
                        success: function(response) {
                            $('#form').html(response);
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
                        url: 'ajax/job/IN/Form_Installation.php',
                        dataType: 'html',
                        success: function(response) {
                            $('#form').html(response);
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

                            $('#chkbox').iCheck({
                                checkboxClass: 'icheckbox_square-green',
                                radioClass: 'iradio_square-green',
                            }).on('ifChanged', function(e) {
                                if ($('#chkbox').is(':checked') == true) {
                                    $('#non_customer').val('1');
                                } else {
                                    $('#non_customer').val('0');
                                }
                            });
                        }
                    });
                } else if (job_type == 4) {
                    $.ajax({
                        url: 'ajax/job/job_overhaul/form_add_overhaul.php',
                        dataType: 'html',
                        success: function(response) {
                            $('#form').html(response);
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
                        url: 'ajax/job/Other/form_add_other_job.php',
                        dataType: 'html',
                        success: function(response) {
                            $('#form').html(response);
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
                        url: 'ajax/job/quotation/form_add_quotation.php',
                        dataType: 'html',
                        success: function(response) {

                            $('#form').html(response);
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

                } else if (job_type == 7) {
                    $.ajax({
                        url: 'ajax/job/Audit/Form_Audit.php',
                        dataType: 'html',
                        success: function(response) {

                            $('#form').html(response);
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
        });


    }



    function Modal_refjob() {


        var job_type = $('#job_type').val();


        if (job_type == 2) {

            var increment = $('#counter').html();

            var appointment_date = $('#appointment_date_' + increment).val();
        } else {

            var appointment_date = $('#appointment_date').val();
            var customer_branch_id = $('#customer_branch_id').val();
        }

        if (appointment_date == "" || customer_branch_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาเลือกวันที่นัดหมายและสาขา',
                type: 'error'
            });
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "ajax/job/Modal_RefJob.php",
                data: {
                    appointment_date: appointment_date,
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



    function Search() {
        var search_box = $('#search_box').val();
        var search_type = $('#search_type').val();

        ////// เช็คว่ามาจากงาน QC หรือไม่
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const job = urlParams.get('job');
        let chk_job;
        if (job == 'qc') {
            chk_job = job;
        } else {
            chk_job = '';
        }
        console.log(job);
        //////

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
                url: "ajax/job/ModalSearch.php",
                data: {
                    search_box: search_box,
                    search_type: search_type,
                    chk_job: chk_job
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






    /////////////////////CM///////////////////

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


    function Submit() {

        var job_type = $('#job_type').val();
        // var customer_branch_id = $('#customer_branch_id').val();
        // var contact_name = $('#contact_name').val();
        // var contact_position = $('#contact_position').val();
        // var contact_phone = $('#contact_phone').val();
        var product_id = $('#choose_product_id').val();
        var hours = $('#hours').val();
        var branch_care_id = $('#branch_care_id').val();
        var responsible_user_id = $('#responsible_user_id').val();
        var topic_id = $('#topic_id').val();
        var sub_job_type_id = $('#sub_job_type_id').val();
        var mechanic = $('#mechanic').val();
        var dealer_mechanic = $('#dealer_mechanic').val();

        var formData = new FormData($("#form_add_job")[0]);

        if (job_type == "" || product_id == "" || hours == "" || branch_care_id == "") {
            if (mechanic == "0") {
                responsible_user_id = "";
            } else {
                dealer_mechanic = "";
            }
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
            document.getElementById("submit").disabled = true;
            $.ajax({
                type: 'POST',
                url: 'ajax/job/CM/Add_qc.php',
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
                            text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาทำรายการใหม่!!',
                            type: 'warning'
                        });
                        document.getElementById("submit").disabled = false;
                        return false;
                    }

                }
            })
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
            url: 'ajax/job/PM/Check_Pm_job.php',
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



    function modal_add_cus() {
        $.ajax({
            type: "post",
            url: "ajax/job/quotation/modal_add_cus.php",
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


    function desty_staff(i) {
        document.getElementById('row_staff_' + i).remove();

    }

    function desty_product(i) {
        document.getElementById('row_product_' + i).remove();

    }

    function desty_audit(i) {
        document.getElementById('row_topic_' + i).remove();

    }
</script>