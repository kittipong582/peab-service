<?php
include 'header2.php';
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$manual_id = mysqli_real_escape_string($connect_db, $_GET['manual_id']);
$model = mysqli_real_escape_string($connect_db, $_GET['model']);

$sql = "SELECT * FROM tbl_product_brand";
$res = mysqli_query($connect_db, $sql);

$sql_model = "SELECT * FROM tbl_product_model WHERE brand_id='$brand_id' ";
$result = mysqli_query($connect_db, $sql);


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 ">
        <center>
            <h2>จับคู่อาการเสียกับอะไหล่</h2>
        </center>
    </div>
</div>
<div class="row">
    
</div>

<div class="col-6">
    <div id="show_select"></div>
</div>

</div>

<div id="show_data"></div>

</div>
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function () {
        Get_data();
        $(".select2").select2();
    });

    function Get_data() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('manual_id');
        const model = urlParams.get('model');
    
        $.ajax({
            type: 'POST',
            url: "ajax/spare_manual/Get_data.php",
            data: {
                manual_id: manual_id,
                model: model
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('#Loading').hide();
            }
        });
    }



    function ModalAddbroken(manual_sub_id) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('manual_id');
        const model_id = urlParams.get('model');
        $.ajax({
            url: "ajax/spare_manual/ModalAddbroken.php",
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
            url: "ajax/spare_manual/Modal_detail.php",
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
            url: "ajax/spare_manual/Get_spare_type.php",
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
                url: 'ajax/spare_manual/Add_broken.php',
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
                url: 'ajax/spare_manual/Delete.php',
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