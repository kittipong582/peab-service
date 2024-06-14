<?php include 'header2.php';

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$url = '../asset/peaberry.jpg';

$user_id;


?>

<div class="mt-2"></div>
<style>
    .container {
        background-color: #fff;
    }
</style>

<body>
    <div class="container">
        <div class="row m-0 p-1">
            <div class="col-12 p-2">
                <div id="show_data"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content animated fadeIn">
                <div id="showModal"></div>
            </div>
        </div>
    </div>
</body>

<!-- </div> -->
<?php include 'footer.php'; ?>
<script>
    $(".select2").select2();

    $(document).ready(function () {
        GetForm(1);
    });

    function SubmitRecord(page) {
        // get จาก url
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const product_type = urlParams.get('product_type');

        let checklist_id = $("#checklist_id").val();
        let score = $('input[name="score"]:checked').val();
        let produce_img1 = $("#produce_img1").val();
        let produce_img2 = $("#produce_img2").val();
        let text_score = $("#text_score").val();

        let formData = new FormData($("#frm_audit")[0]);
        formData.append('product_type', product_type);

        if (checklist_id == '' || score == null) {
            swal({
                title: '',
                text: 'กรุณาเลือกตัวเลือก ก่อนไปข้อถัดไป',
                type: 'warning',
                showConfirmButton: false,
                timer: 1500
            });
            return false
        }

        $.ajax({
            type: "POST",
            url: "ajax/qc_form/add_record.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.result == 1 || data.result == 2) {
                    GetForm(page)
                }
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect. Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error. ' + jqXHR.responseText;
                }

                swal({
                    title: "แจ้งเตือน",
                    text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                    type: "error",
                    showConfirmButton: true
                });
            }
        });
    }

    function GetForm(page) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const product_type = urlParams.get('product_type');
        const job = urlParams.get('job');
        // console.log(job)
        $.ajax({
            type: "POST",
            url: "ajax/qc_form/get_form.php",
            data: {
                page: page,
                product_type: product_type,
                job, job
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $(".select2").select2();
            }
        });
    }

    function SubmitChecklist(page) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const product_type = urlParams.get('product_type');
        const job = urlParams.get('job');

        let checklist_id = $("#checklist_id").val();
        let text_score = $("#text_score").val();
        let score = $('input[name="score"]:checked').val();
        let produce_img1 = $("#produce_img1").val();
        let produce_img2 = $("#produce_img2").val();
        let checklist_type = $("#checklist_type").val();
        let checklist_input = "";
        if (checklist_type == 1) {
            checklist_input = text_score
        } else if (checklist_type == 2) {
            checklist_input = score
        }

        let formData = new FormData($("#frm_audit")[0]);
        formData.append('product_type', product_type);

        console.log(job)
        if (checklist_id == '' || checklist_input == null) {
            swal({
                title: '',
                text: 'กรุณาเลือกตัวเลือก ก่อนไปข้อถัดไป',
                type: 'warning',
                showConfirmButton: false,
                timer: 1500
            });
            return false
        }

        $.ajax({
            type: "POST",
            url: "ajax/qc_form/add_record.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.result == 1 || data.result == 2) {
                    $("#show_data").load("ajax/qc_form/get_summary_form.php", {
                        job: job,
                        product_type: product_type,
                        text_score: text_score,
                        page: page
                    });
                }
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect. Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error. ' + jqXHR.responseText;
                }

                swal({
                    title: "แจ้งเตือน",
                    text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                    type: "error",
                    showConfirmButton: true
                });
            }
        });
    }

    function SubmitChecklistHead() {
        let sum_score = $("#sum_score").val();
        let close_qc = $("#close_qc").val();
        let job_id = $("#job_id").val();
        let remark = $("#remark").val();
        $.ajax({
            type: "POST",
            url: "ajax/qc_form/update_summary.php",
            data: {
                sum_score: sum_score,
                close_qc: close_qc,
                remark: remark,
                job_id: job_id
            },
            dataType: "json",
            success: function (data) {
                if (data.result == 1) {
                    swal({
                        title: 'บันทึกข้อมูลสำเร็จ',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }, function () {
                        swal.close();
                        window.location.href = 'qc_work_list.php'
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
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect. Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error. ' + jqXHR.responseText;
                }

                swal({
                    title: "แจ้งเตือน",
                    text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                    type: "error",
                    showConfirmButton: true
                });
            }
        });
    }

    function ModalImage(record_id) {
        console.log(record_id);
        $("#myModal").modal("show");
        $("#showModal").load("ajax/qc_form/modal_image.php", {
            record_id: record_id
        });
    }


    // function add_img() {
    //     $('#img_counter').html(function (i, val) {
    //         return +val + 1;
    //     });
    //     var increment = $('#img_counter').html();

    //     $.ajax({
    //         url: 'ajax/qc_form/get_img.php',
    //         type: 'POST',
    //         dataType: 'html',
    //         data: {
    //             rowCount: increment,
    //         },
    //         success: function (data) {
    //             $('#Add_img_form').append(data);
    //             $(".select2").select2({
    //                 width: "100%"
    //             });
    //         },
    //     });
    // }


    function add_img() {
        $('#img_counter').html(function (i, val) {
            return +val + 1;
        });
        var rowCount = $('#img_counter').html();

        $.ajax({
            url: 'ajax/qc_form/get_img.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: rowCount,
            },
            success: function (data) {
                $('#Add_img_form').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            },
        });
    }

</script>