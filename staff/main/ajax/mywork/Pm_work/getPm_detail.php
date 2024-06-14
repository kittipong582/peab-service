<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT img_id,pm_image FROM tbl_pm_image WHERE job_id = '$job_id' ORDER BY list_order";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

?>

<label><b>รูป PM</b></label>



<div class="row">
    <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
        <div class="col-3 mb-2 text-center">
            <a target="_blank" href="upload/pm_image/<?php echo $row['pm_image']; ?>" data-lity>
                <img class="mb-3" loading="lazy" src="upload/<?php echo ($row['pm_image'] == "") ? "No-Image.png" : "pm_image/" . $row['pm_image']; ?>" width="220px" height="220px" />
            </a>


            <div class="form-group ">
                <button type="button" class="btn btn-danger btn-sm" onclick="delete_pm_img('<?php echo $row['img_id'] ?>')">ลบ</button>
            </div>

        </div>
    <?php } ?>
</div>

<script>
    function delete_pm_img(img_id) {

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

                url: 'ajax/mywork/Pm_work/delete_img.php',

                data: {

                    img_id: img_id

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
                        }, 500);
                        $("#modal").modal('hide');
                        Getdata();
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