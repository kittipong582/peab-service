<?php
include 'header2.php';
include ("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$manual_id = mysqli_escape_string($connect_db, $_GET['manual_id']);
$model_id = mysqli_escape_string($connect_db, $_GET['model']);

$sql_manual_sub = "SELECT * FROM tbl_manual_basic_sub a WHERE a.manual_id = '$manual_id'";
$res_manual_sub = mysqli_query($connect_db, $sql_manual_sub) or die($connect_db->error);



// echo $sql;
?>
<style>
    .select2-container {
        z-index: 9999;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>คู่มือย่อย</h2>
        </center>

    </div>
</div>

<?php while ($row_manual_sub = mysqli_fetch_assoc($res_manual_sub)) { ?>
    <div class="ibox mb-1 d-block border">
        <div class="ibox-title">
            <b>
                <?php echo $row_manual_sub['manual_sub_name']; ?>
            </b>
            <br>
        </div>
        <div class="ibox-content">
            <table class="">
                <thead>
                    <tr>
                        <!-- <td><b>เหตุผล</b></td> -->
                    </tr>
                </thead>
                <tbody class=" mt-5 text-left">
                    <tr>
                        <td>
                            <?//php echo $row_manual_sub['remark']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">
                    <!-- <a href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_manual_sub['file_name']; ?>"
                        target="_blank" class="btn btn-info mr-2">ไฟล์</a> -->
                    <button class="btn btn-primary mr-2"
                        onclick="ModalAddbroken('<?php echo $row_manual_sub['manual_sub_id'] ?>')">เพิ่มอะไหล่</button>
                    <button class="btn btn-success"
                        onclick="Modal_Detail('<?php echo $row_manual_sub['manual_sub_id'] ?>')">อะไหล่</button>
                </div>
            </div>
        </div>

    </div>

<?php } ?>
<div class="modal fade" id="myModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function () {
        $(".select2-container").select2();
    });
    function ModalAddbroken(manual_sub_id) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('manual_id');
        const model_id = urlParams.get('model');
        $.ajax({
            url: "ajax/spare_manual_sub/ModalAddbroken.php",
            data: {
                manual_id: manual_id,
                manual_sub_id: manual_sub_id,
                model_id: model_id
            },
            type: "POST",
            success: function (response) {
                $("#myModal .modal-content").html(response);
                $("#myModal").modal('show');
                $(".select2-container").select2({
                    width: "100%"
                });
            }
        });
    }

    function Modal_Detail(manual_sub_id) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('manual_id');
        const model_id = urlParams.get('model');
  
        $.ajax({
            url: "ajax/spare_manual_sub/Modal_detail.php",
            data: {
                manual_id: manual_id,
                manual_sub_id: manual_sub_id,
                model_id: model_id
            },
            type: "POST",
            success: function (response) {
                $("#myModal .modal-content").html(response);
                $("#myModal").modal('show');
                $(".select2-container").select2({
                    width: "100%"
                });
            }
        });
    }

    function Get_spare_type() {
        var spare_type_id = $('#spare_type_id').val();
        $.ajax({
            type: 'POST',
            url: "ajax/spare_manual_sub/Get_spare_type.php",
            data: {
                spare_type_id: spare_type_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_select").html(response);
                $('#Loading').hide();
                $(".select2-container").select2({
                    width: "100%"
                });
            }
        });
    }

    function Add_broken() {
        var manual_name = $('#manual_name').val();
        var formData = new FormData($("#form-add-broken")[0]);


    

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
                url: 'ajax/spare_manual_sub/Add_broken.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณณาติดต่อเจ้าหน้าที่',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#myModal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                    }
                }
            });
        });
    }

    function Delete(spare_broken_id) {

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
                url: 'ajax/spare_manual_sub/Delete.php',
                data: {
                    spare_broken_id: spare_broken_id
                },
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 500);
                        $("#myModal").modal('hide');
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }

            });
        });

    }

</script>