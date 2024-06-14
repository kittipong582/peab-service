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
                                <strong>ประเภทงาน </strong>
                                <font color="red">**</font><br>
                                <!--code คือ branch_code ที่ส่งมา แค่จะปิด disabled-->
                                <select name="job_type" id="job_type" style="width: 100%;" class="form-control select2 mb-3 " onchange="job_form(this.value)" <?php echo ($_GET['code'] != '' ? 'disabled' : ''); ?>>
                                    <option value="">กรุณาเลือกประเภท</option>
                                    <option value="1" <?php echo ($_GET['job_type'] == '1') ? "selected" : ""; ?>>CM
                                    </option>
                                    <option value="2">PM</option>
                                    <option value="8">PM GROUP</option>
                                    <option value="3">Installation</option>
                                    <option value="4" <?php echo ($_GET['job_type'] == '4') ? "selected" : ""; ?>>OverHaul
                                    </option>
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
        <div class="modal-content" id="showdata">

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
        if (job_type != null) { // ค่า get = 1 = งาน CM รับงานมาจาก QC
            job_form(job_type)

        }
    });

    function job_form(job_type) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const sn = urlParams.get('sn');
        const job = urlParams.get('job');
        const branch_code = urlParams.get('code');
        const customer_branch_id = urlParams.get('id');
        $.ajax({
            type: 'POST',
            url: 'ajax/job/get_form_add.php',
            data: {
                job_type: job_type,
                sn: sn,
                st: job_type,
                branch_code: branch_code,
                customer_branch_id: customer_branch_id
            },
            dataType: 'html',
            success: function(response) {
                $('#from_add').html(response);
                $(".select2").select2({});
                if (job_type == 1) {
                    $.ajax({
                        url: 'ajax/job/CM/Form_CM.php',
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
                            if (sn != null) {
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
                            if (branch_code != null) {
                                SearchOH();
                            }
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
                } else if (job_type == 8) {
                    $.ajax({
                        url: 'ajax/job/PM_GROUP/Form_PM.php',
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
        if (job == 'qc') {
            let chk_job = job;
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

    function Submit() {

        var job_type = $('#job_type').val();
        var customer_branch_id = $('#customer_branch_id').val();
        var contact_name = $('#contact_name').val();
        var contact_position = $('#contact_position').val();
        var contact_phone = $('#contact_phone').val();
        var product_id = $('#choose_product_id').val();
        var hours = $('#hours').val();
        var branch_care_id = $('#branch_care_id').val();
        var responsible_user_id = $('#responsible_user_id').val();
        var topic_id = $('#topic_id').val();
        var sub_job_type_id = $('#sub_job_type_id').val();
        var mechanic = $('#mechanic').val();
        var dealer_mechanic = $('#dealer_mechanic').val();

        var formData = new FormData($("#form_add_job")[0]);

        if (job_type == "" || customer_branch_id == "" || contact_name == "" || contact_phone == "" || product_id == "" ||
            hours == "" || branch_care_id == "") {
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
                url: 'ajax/job/CM/Add.php',
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

    function Submit_audit() {

        var job_type = $('#job_type').val();
        var customer_branch_id = $('#customer_branch_id').val();
        var contact_name = $('#contact_name').val();
        var contact_position = $('#contact_position').val();
        var contact_phone = $('#contact_phone').val();
        var product_id = $('#choose_product_id').val();
        var hours = $('#hours').val();
        var branch_care_id = $('#branch_care_id').val();
        var responsible_user_id = $('#responsible_user_id').val();
        var topic_id = $('#topic_id').val();
        var sub_job_type_id = $('#sub_job_type_id').val();

        var formData = new FormData($("#form_add_job")[0]);

        if (job_type == "" || customer_branch_id == "" || contact_name == "" || contact_phone == "" || product_id == "" ||
            hours == "" || branch_care_id == "" || responsible_user_id == "") {
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
                url: 'ajax/job/Audit/Add.php',
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




    //////////////////////////PM/////////////////////////

    function SearchPM() {
        var search_box = $('#search_box').val();
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
                url: "ajax/job/PM/ModalSearch.php",
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

    function SearchPMGroup() {
        var search_box = $('#search_box').val();
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
                url: "ajax/job/PM_GROUP/ModalSearch.php",
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

        var check_plan = $('#check_plan').val();
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
            url: "ajax/job/PM/addPMForm.php",
            dataType: "html",
            data: {
                Count_Row: increment,
                check_plan: check_plan,
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
                    url: "ajax/job/PM/GetSelectPM_User.php",
                    data: {
                        branch_id: check_plan,
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


    function create_plan() {

        var check_plan = $('#check_plan').val();
        var PMcounter = parseInt(1);
        var plan_times = parseInt($('#plan_times').val());
        var start_help_date = $('#start_help_date').val();
        var distance_date = $('#distance_date').val();
        $('.new_pm_form').remove();
        $('.new_pm_multi_form').remove();
        var row = (PMcounter + plan_times);

        $.ajax({
            type: 'POST',
            url: "ajax/job/PM/addPM_MultiForm.php",
            dataType: "html",
            data: {
                Count_Row: PMcounter,
                start_help_date: start_help_date,
                distance_date: distance_date,
                plan_times: plan_times,
                row: row,
                check_plan: check_plan,
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
                        url: "ajax/job/PM/GetSelectPM_User.php",
                        data: {
                            branch_id: check_plan,
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
            url: "ajax/job/PM/ModalOther_Care.php",
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
        $("#pm_date").val(date);

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

    function get_Pm_care(branch_id, i) {

        $.ajax({
            type: "POST",
            url: "ajax/job/PM/GetSelect_PM_User.php",
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

        var sub_job_type_id = $('#sub_job_type_id').val();


        var formData = new FormData($("#form_add_job")[0]);

        if (job_type == "" || customer_branch_id == "" || contact_name == "" || contact_phone == "" || product_id == "") {
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
                url: 'ajax/job/PM/Add_PM.php',
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


    /////////////////////////////////Istallation///////////////////////
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


    function Submit_IN() {

        var job_type = $('#job_type').val();
        var sub_job_type_id = $('#sub_job_type_id').val();


        var formData = new FormData($("#form_add_job")[0]);
        var non_customer = $('#non_customer').val();

        if (non_customer == 1) {

            if (job_type == "" || sub_job_type_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        } else {

            var customer_branch_id = $('#customer_branch_id').val();
            var contact_name = $('#contact_name').val();
            var contact_phone = $('#contact_phone').val();

            if (job_type == "" || sub_job_type_id == "" || customer_branch_id == "" || contact_name == "" ||
                contact_phone == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
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
            document.getElementById("submit").disabled = true;
            $.ajax({
                type: 'POST',
                url: 'ajax/job/IN/Add_IN.php',
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
                    } else if (data.result == 2) {
                        swal({
                            title: "ผิดพลาด!",
                            text: "หมายเลขเครื่องซ้ำ กรุณาทำรายการใหม่",
                            type: "warning",
                            showConfirmButton: true
                        });
                        document.getElementById("submit").disabled = false;
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



    //////////////////////////OH//////////////////////////////

    function SearchOH() {
        var search_box = $('#search_box').val();
        var search_type = $('#search_type').val();
        var search_box2 = $('#search_box2').val();

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
                url: "ajax/job/job_overhaul/ModalSearch.php",
                data: {
                    search_box: search_box,
                    search_type: search_type,
                    search_box2: search_box2

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

                    $.ajax({
                        type: "POST",
                        url: "ajax/job/job_overhaul/GetProduct.php",
                        data: {

                        },
                        dataType: "html",
                        success: function(response) {
                            $("#productpoint").html(response);
                            $(".select2").select2({});
                        }
                    });
                }
            });

        }
    }



    function Other_care_OH() {
        $.ajax({
            type: "post",
            url: "ajax/job/job_overhaul/ModalOther_Care.php",
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



    function getproduct_detail(product_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/job_overhaul/getproduct_detail.php",
            data: {
                product_id: product_id
            },
            dataType: "json",
            success: function(response) {
                $("#product_type").val(response.product_type);
                $("#serial_no").val(response.serial_no);
                $("#model").val(response.model_name);
                $("#brand").val(response.brand_name);
                $("#product_id").val(response.product_id);
                $("#warranty_start_date").val(response.warranty_start_date);
                $("#warranty_expire_date").val(response.warranty_expire_date);
                $("#modal").modal('hide');
            }
        });


    }






    function Other_careOH() {
        $.ajax({
            type: "post",
            url: "ajax/job/job_overhaul/ModalOther_Care.php",
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

                $("#o_warranty_start_date").val(response.warranty_start_date);
                $("#o_warranty_expire_date").val(response.warranty_expire_date);

            }
        });
    }

    function Submit_OH() {

        var customer_branch_id = $('#customer_branch_id').val();
        var contact_name = $('#contact_name').val();
        var contact_position = $('#contact_position').val();
        var contact_phone = $('#contact_phone').val();
        var product_id = $('#product_id').val();

        var branch_care_id = $('#branch_care_id').val();
        var formData = new FormData($("#form_add_job")[0]);

        if (customer_branch_id == "" || contact_name == "" || contact_phone == "" || branch_care_id == "") {
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
                url: 'ajax/job/job_overhaul/Add.php',
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


    ///////////////////////OTH//////////////////////////////

    function SearchOth() {
        var search_box = $('#searchoth_box').val();
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
                url: "ajax/job/Other/ModalSearch.php",
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


    function Submit_OTH() {


        var branch_care_id = $('#branch_care_id').val();
        var formData = new FormData($("#form_add_job")[0]);
        var sub_job_type = $('#sub_job_type').val();

        if (branch_care_id == "" || sub_job_type == "") {
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
                url: 'ajax/job/Other/Add.php',
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





    //////////////////////////////search_qt////////////////////////


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



    function Submit_QT() {

        var job_customer_type = $('#job_customer_type').val();
        var counter = $('#counter').html();
        var customer_name = $('#customer_name').val();
        var customer_branch_id = $('#customer_branch_id').val();

        var tr = $('#tr_' + counter).val();
        var qt = $('#qs_id_' + counter).val();
        var unit = $('#unit_' + counter).val();
        var quantity = $('#quantity_' + counter).val();
        var formData = new FormData($("#form_add_job")[0]);

        formData.append('uploadfile', $('input[type=file]')[0].files[0]);
        if (job_customer_type == 1) {
            if (customer_branch_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
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
                url: 'ajax/job/quotation/Add.php',
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
                        return false;
                    }

                }
            })
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

    //////// PM GROUP////////

    function RemoveMCTab(num_tab) {
        const element_li = document.getElementById("li_" + num_tab);
        const element_tab = document.getElementById("tab-" + num_tab);
        element_li.remove();
        element_tab.remove();

        // let new_tab = num_tab - 1;
        // $("#num_tab").val(new_tab);
    }

    function add_row_tab(num_tab) {
        $('#counter_' + num_tab).html(function(i, val) {
            return +val + 1
        });
        var increment = $('#counter_' + num_tab).html();
        $.ajax({
            url: 'ajax/job/PM_GROUP/Add_row_service.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
                tab: num_tab
            },
            success: function(data) {

                $('#Addform_' + num_tab).append(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }


    function select_ServiceTab(service_id, i, num_tab) {

        var quantity = $('#quantity_' + i + '_tab_' + num_tab).val();
        $.ajax({
            url: 'ajax/job/Get_service.php',
            type: 'POST',
            dataType: 'json',
            data: {
                service_id: service_id,
            },
            success: function(data) {

                $('#unit_' + i + '_tab_' + num_tab).val(data.unit);
                $('#unit_cost_' + i + '_tab_' + num_tab).val(data.unit_cost);
                var cost_price = parseFloat(quantity) * parseFloat(data.unit_cost) || 0;

                $('#unit_price_' + i + '_tab_' + num_tab).val(cost_price);


            }
        });
    }

    function destyTab(i, num_tab) {
        document.getElementById('tr_' + i + '_tab_' + num_tab).remove();
    }



    function CalTab(quantity, i, num_tab) {
        var unit_cost = $('#unit_cost_' + i + '_tab_' + num_tab).val();
        var cost_price = parseFloat(quantity) * parseFloat(unit_cost) || 0;
        $('#unit_price_' + i + '_tab_' + num_tab).val(cost_price);


    }

    function GetModalAddMC() {
        var choose_product_id = $("input[name='choose_product_id[]']")
            .map(function() {
                return $(this).val();
            }).get();
        var customer_branch_id = $('#customer_branch_id').val();
        $("#modal").modal('show');
        $("#showdata").load("ajax/job/PM_GROUP/get_modal_MC.php", {
            customer_branch_id: customer_branch_id,
            choose_product_id: choose_product_id
        }, function() {
            $(".select2").select2();
        });

    }

    function AddTab(product_id) {
        $("#showdata").html('');
        let num_tab = $("#num_tab").val();
        new_tab = parseInt(num_tab) + 1;

        $.ajax({
            url: 'ajax/job/PM_GROUP/Add_tab_nav.php',
            type: 'POST',
            dataType: 'html',
            data: {
                product_id: product_id,
                num_tab: new_tab
            },
            success: function(data) {
                $('#mc_nav').append(data);

                $.ajax({
                    url: 'ajax/job/PM_GROUP/Add_tab_content.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        product_id: product_id,
                        num_tab: new_tab
                    },
                    success: function(data) {
                        $('#tab_content').append(data);
                        $("#modal").modal("hide");
                    }
                });
            }
        });


    }

    function Submit_PMGROUP() {

        var job_type = $('#job_type').val();
        var customer_branch_id = $('#customer_branch_id').val();
        var contact_name = $('#contact_name').val();
        var contact_position = $('#contact_position').val();
        var contact_phone = $('#contact_phone').val();
        var product_id = $('#choose_product_id').val();

        var sub_job_type_id = $('#sub_job_type_id').val();


        var formData = new FormData($("#form_add_job")[0]);

        if (job_type == "" || customer_branch_id == "" || contact_name == "" || contact_phone == "" || product_id == "" || sub_job_type_id == "") {
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
            // document.getElementById("submit").disabled = true;
            $.ajax({
                type: 'POST',
                url: 'ajax/job/PM_GROUP/Add_PM.php',
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
                            showConfirmButton: true,
                            timer: 1000
                        }, function() {
                            window.location.href = 'job_list.php';
                        });
                       
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




    //////// PM GROUP////////
</script>