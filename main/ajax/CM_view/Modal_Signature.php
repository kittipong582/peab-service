<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_customer_branch e ON a.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
WHERE a.job_id = '$job_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
// echo $sql;
?>





<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div id="signatureArea">
            <div style="height:auto;">
                <canvas id="signaturePad" width="750" height="300"></canvas>
            </div>
        </div>
        <img id="canvasImage" />
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_sign()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function () {

    });


    function Submit_sign() {

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


            html2canvas([document.getElementById('signaturePad')], {
                onrendered: function (canvas) {
                    var canvas_img_data = canvas.toDataURL();


                    $.ajax({
                        type: 'POST',
                        url: 'ajax/CM_view/Save_Signature.php',
                        data: {
                            canvas_img_data: canvas_img_data
                        },
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
                                $("#modal").modal('hide');
                            } else if (data.result == 0) {
                                swal({
                                    title: 'ผิดพลาด!',
                                    text: 'จำนวนอะไหล่ไม่พอ กรุณากรอกใหม่ !!',
                                    type: 'warning'
                                });
                                return false;
                            }

                        }
                    })

                }
            });
        });


    }
</script>