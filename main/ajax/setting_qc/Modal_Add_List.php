<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$checklist_id = $_POST['checklist_id'];

$no = 1;

$sql = "SELECT * FROM tbl_product_type_qc_checklist_choice WHERE checklist_id = $checklist_id ";
$res = mysqli_query($connect_db, $sql);
?>
<div class="row">
    <div class="col">
        <form action="" method="post" id="form-list" enctype="multipart/form-data">
            <input type="text" hidden class="form-control" value="<?php echo $checklist_id ?>" id="checklist_id"
                name="checklist_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><strong>เพิ่ม</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-9 mb-3">
                        <label for="choice_name">หัวข้อ</label>
                        <input type="text" class="form-control" id="choice_name" name="choice_name">
                    </div>
                    <div class="col-3 mb-3 d-flex align-items-end">
                        <button class="btn btn-primary btn-block" type="button" id="submit"
                            onclick="AddList()">บันทึก</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>หัวข้อ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td>
                            <?php echo $no; ?>
                        </td>

                        <td>
                            <?php echo $row['choice_name']; ?>
                        </td>

                        <td class="text-center">
                            <button class="btn btn-xs btn-danger btn-block" type="button"
                                onclick="Delete('<?php echo $row['choice_id']; ?>')">
                                ลบ
                            </button>
                        </td>

                    </tr>
                    <?php $no++; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function () {
        // $('#qc').DataTable({
        //     paging: false,
        //     responsive: true
        // });
        GetTable();

    });
    // function  {
    //     $.ajax({
    //         url: "ajax/setting_qc/Modal_Add_List.php",
    //         dataType: "html",
    //         success: function (response) {
    //             $('#qc').DataTable({
    //                 pageLength: 25,
    //                 responsive: true
    //             });
    //         }
    //     });
    // }
    function AddList() {
        var checklist_id = $('#checklist_id').val();
        var choice_name = $('#choice_name').val();
        var formData = new FormData($("#form-list")[0]);

        if (choice_name == "") {
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
                url: 'ajax/setting_qc/Add_Qc_list.php',
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
                            showConfirmButton: false
                        });
                        swal.close();
                        // $("#modal").modal('hide');              
                        ModalList(checklist_id);

                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }
                }
            })
        });

    }

    function Delete(choice_id) {
        var checklist_id = $('#checklist_id').val();
        swal({
            title: "แจ้งเตือน",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5564",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/setting_qc/Delete.php",
                data: {
                    choice_id: choice_id
                },
                beforeSend: function () {
                    swal({
                        title: "กำลังทำการบันทึก",
                        text: "กรุณารอสักครู่",
                        imageUrl: "ajax/ajax-loader.gif",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
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
                },
                success: function (response) {
                    if (response.result == 1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            // $("#modal").modal('hide');              
                            ModalList(checklist_id);
                        });
                    } else if (response.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ',
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