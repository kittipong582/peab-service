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
        <form id="form-add" method="POST" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">
            </div>

            <div class="row m-0 p-1">
                <div class="col-12 p-2">
                    <h3>เลือกสาขา</h3>
                    <div class="my-3">
                        <input type="text" class="form-control datepicker text-center" name="appointment_date"
                            id="appointment_date">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">ค้นหาจาก</label>
                        <select class="select2 w-100" name="search_type" id="search_type">
                            <option value="1">ชื่อลูกค้า/เบอร์โทร</option>
                            <option value="2">รหัสสาขา/ชื่อสาขา</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="search_value" name="search_value" class="form-control">
                        <span class="input-group-append"><button type="button" id="btn_search_PM"
                                class="btn btn-primary" onclick="ModalSearch()"><i
                                    class="fa fa-search"></i></button></span>
                    </div>
                    <hr>
                    <h3>ข้อมูลสาขา</h3>
                    <div class="form-group">
                        <input type="hidden" id="customer_branch_id" name="customer_branch_id">
                        <label for="">รหัสสาขา</label>
                        <input type="text" name="branch_code" id="branch_code" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">ชื่อลูกค้า</label>
                        <input type="hidden" id="customer_id" name="customer_id">
                        <input type="text" name="customer_name" id="customer_name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">ชื่อสาขา</label>
                        <input type="text" name="branch_name" id="branch_name" class="form-control" readonly>
                    </div>
                    <hr>
                    <div class="form-group mb-3">
                        <button type="button" class="btn btn-primary w-100" onclick="AddAudit()">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
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

    $('.datepicker').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    }).datepicker("setDate", 'now');

    $(document).ready(function () {

    });

    function ModalSearch() {
        let search_type = $("#search_type").val();
        let search_value = $("#search_value").val();
        if (search_value == '') {
            $("#search_value").focus();
            return false;
        }
        $("#myModal").modal("show");
        $.ajax({
            type: "POST",
            url: "ajax/audit_work/modal_search.php",
            data: {
                search_type: search_type,
                search_value: search_value
            },
            dataType: "html",
            success: function (response) {
                $("#showModal").html(response);
            }
        });
    }

    // function CheckCustomer(user_id) {
    //     let branch_id = $("#branch_id").val();
    //     if (branch_id == '') {
    //         swal({
    //             title: 'กรุณาเลือก ร้าน / สาขา',
    //             text: '',
    //             type: 'warning',
    //             showConfirmButton: false,
    //             timer: 1500
    //         });
    //         return false;
    //     }
    //     window.location.href = 'audit_list.php?user=' + user_id + '&branch=' + branch_id;

    // }

    function AddAudit() {
        var appointment_date = $("#appointment_date").val();

        if (appointment_date == "") {
            swal({
                title: 'กรุณากรอกข้อมูล',
                text: '',
                type: 'warning',
                showConfirmButton: false,
                timer: 1000
            }, function () {
                swal.close()

            });

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
        }, function () {
            let formData = new FormData($("#form-add")[0]);
            $.ajax({
                type: "POST",
                url: "ajax/audit_work/Add.php",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
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
                            $("#myModal").modal('hide');
                            window.location.href='audit_work_list.php';
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

</script>