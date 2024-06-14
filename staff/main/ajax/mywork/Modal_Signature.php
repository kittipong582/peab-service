<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

// echo $sql;
?>

<style>
    #signaturePad {

        cursor: crosshair;
    }
</style>




<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
        <div id="signatureArea">
            <div style="height:auto;">
                <canvas id="signaturePad" width="300" height="285"></canvas>
            </div>
        </div>
        <img id="canvasImage" />
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit()">บันทึก</button>
    </div>
</form>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {


    });

    function Submit() {

        var job_id = $('#job_id').val();

        html2canvas([document.getElementById('signaturePad')], {
            onrendered: function(canvas) {


                var canvas_img_data = canvas.toDataURL();

                $.ajax({
                    type: 'POST',
                    url: 'ajax/mywork/Save_Signature.php',
                    data: {
                        canvas_img_data: canvas_img_data,
                        job_id: job_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == 1) {
                            swal({
                                title: "ดำเนินการสำเร็จ!",
                                text: "ทำการบันทึกรายการ เรียบร้อย",
                                type: "success",
                                showConfirmButton: false
                            });
                            setTimeout(function() {
                                swal.close();
                            }, 750);
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



    }
</script>