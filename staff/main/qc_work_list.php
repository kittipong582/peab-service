<?php include 'header2.php';

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$url = '../asset/peaberry.jpg';

$user_id;


?>
<link href="signature/css/jquery.signaturepad.css" rel="stylesheet">
<script src="signature/js/jquery_1_10_2.min.js"></script>
<script src="signature/js/numeric-1.2.6.min.js"></script>
<script src="signature/js/bezier.js"></script>
<script src="signature/js/jquery.signaturepad.js"></script>

<script type='text/javascript' src="signature/js/html2canvas.js"></script>
<script src="signature/js/json2.min.js"></script>

<style type="text/css">
    #signArea {
        width: 100%;
        margin: 0px auto;
    }

    .sign-container {
        width: 60%;
        margin: auto;
    }

    .sign-preview {
        width: 100%;
        height: 50px;
        border: solid 1px #CFCFCF;
        margin: 10px 5px;
    }

    .btn-sky {
        color: #fff;
        background-color: #3ed3b6;
        border-color: #3ed3b6;
    }

    A:link {
        color: #0000cc;
        text-decoration: none
    }

    A:visited {
        color: #0000cc;
        text-decoration: none
    }

    A:hover {
        color: red;
        text-decoration: none
    }
</style>

<div class="p-1">
    <div class="row">
        <input type="text" hidden id="user_id" name="user_id" value="<?php echo $user_id ?>">
    </div>
    <div class="row">
        <div class="col-12">
            <label> <input type="checkbox" class="i-checks" id="chk" name="chk" value="x" onchange="Getdata();">
                แสดงทั้งหมด
            </label>
        </div>
        <div class="col-5 mb-2">
            <input type="text" class="form-control datepicker text-center" name="start_date" id="start_date" value="<?php echo date("d/m/Y", strtotime("now -7 days")); ?>" readonly onchange="Getdata();">
        </div>
        <div class="col-2 mb-2">
            <center><label style="padding-top: 1ex;"><b> ถึง </b></label></center>
        </div>
        <div class="col-5 mb-2">
            <input type="text" class="form-control datepicker text-center" name="end_date" id="end_date" value="<?php echo date("d/m/Y", strtotime("now +7 days")); ?>" readonly onchange="Getdata();">
        </div>

        <div class="col-12 mb-2">
            <input type="text" class="form-control mb-2" placeholder="ค้นหาเลขที่ร้าน เช่น (DD0686,CD0112)" id="search" name="search" value="">
            <button type="button" class="btn btn-block btn-success btn-sm" onclick="Getdata();">ค้นหา</button>
        </div>
        <div class="col-12 mb-2">
            <a href="import_product_qc.php" class="btn btn-block btn-primary btn-sm text-white" >เพิ่มงาน</a>
        </div>
    </div>
    <div id="show_data"></div>

</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        Getdata();
        // const queryString = window.location.search;
        // const urlParams = new URLSearchParams(queryString);
        // const work = urlParams.get('work');

        // if (work != null) {
        //     GetModalStart(work)
        // }

    });

    $('.datepicker').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",
    })

    function Getdata() {

        const start_date = $("#start_date").val();
        const end_date = $("#end_date").val();
        const search = $('#search').val();
        const user_id = $('#user_id').val();
        const check_all = $('input[name="chk"]:checked').serialize();

        $.ajax({
            type: 'POST',
            url: "ajax/qc_work_list/Getdata.php",
            data: {
                start_date: start_date,
                end_date: end_date,
                user_id: user_id,
                search: search,
                check_all: check_all
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
            }
        });
    }

    // function GetModalStart(group_id) {

    //     $("#myModal").modal("show");
    //     $("#showModal").load("ajax/qc_work_list/modal_start.php", {
    //         group_id: group_id,
    //     });
    // }

    function Start_Qc(job_qc_id, product_type_id) {
        console.log(job_qc_id)
        console.log(product_type_id)
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
            $.ajax({
                type: "POST",
                url: "ajax/qc_work_list/update_start.php",
                data: {
                    job_qc_id: job_qc_id,
                    product_type_id: product_type_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: 'บันทึกสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function() {
                            swal.close();
                            window.location.href = 'qc_form.php?product_type=' + product_type_id + '&job=' + job_qc_id;

                        });
                    } else if (data.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (data.result == 9) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });
    }

    function Signature() {
        $("#signature_box").load("signature.php");
    }

    function ModalClose(group_id) {
        $("#myModal").modal("show");
        $("#showModal").load("ajax/qc_work_list/close_audit.php", {
            group_id: group_id
        });
    }

    function SubmitColseJob(group_id) {
        let sig_validate = $("#sig_validate").val();
        if (sig_validate == 0) {
            swal({
                title: 'กรุณาบันทึกลายเซ็น',
                text: '',
                type: 'warning',
                showConfirmButton: false,
                timer: 1500
            });

            return false;

        } else {
            let canvas = document.getElementById('sign-pad');
            let img_data = canvas.toDataURL(); // Convert canvas content to base64 image data
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
                    type: "POST",
                    url: "ajax/qc_work_list/update_close_job.php",
                    data: {
                        group_id: group_id,
                        signature: img_data
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.result == 1) {
                            swal({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            }, function() {
                                swal.close();
                                $("#myModal").modal('hide');
                             
                            });
                        } else if (data.result == 0) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: '',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 9) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            })
        }
    }
</script>