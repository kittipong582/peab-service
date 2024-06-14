<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$branch_id = $row['care_branch_id'];
$sql_overhaul = "SELECT * FROM tbl_overhaul WHERE current_branch_id = '$branch_id' AND current_customer_branch_id IS NULL and active_status = 1";
$result_overhaul  = mysqli_query($connect_db, $sql_overhaul);
?>
<form action="" method="post" id="form-add_overhaul" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>เครื่องทดแทน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row mb-3">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <div class="mb-3 col-8">
                <label>เครื่องทดแทน</label>
                <select id="overhaul_id" onchange="select_overhaul(this.value)" name="overhaul_id" style="width: 100%;" class="form-control select2 mb-3">
                    <option value="">กรุณาเลือกเครื่อง</option>
                    <?php while ($row_overhaul = mysqli_fetch_array($result_overhaul)) {

                        if ($row['product_type'] == 1) {
                            $product_type = 'เครื่องชง';
                        } else if ($row['product_type'] == 2) {
                            $product_type = 'เครื่องบด';
                        } else if ($row['product_type'] == 3) {
                            $product_type = 'เครื่องปั่น';
                        }

                        $brand_id = $row_overhaul['brand_id'];
                        $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                        $result_brand  = mysqli_query($connect_db, $sql_brand);
                        $row_brand = mysqli_fetch_array($result_brand);

                        $model_id = $row_overhaul['model_id'];
                        $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                        $result_model  = mysqli_query($connect_db, $sql_model);
                        $row_model = mysqli_fetch_array($result_model);

                    ?>
                        <option value="<?php echo $row_overhaul['overhaul_id'] ?>"><?php echo $row_overhaul['serial_no'] . " - " . $row_brand['brand_name'] . " - " . $row_model['model_name'] ?></option>

                    <?php } ?>
                </select>
            </div>
            <div class="mb-3 col-4">

            </div>

            <div class="mb-3 col-4">
                <label>Serial No</label>
                <input type="text" readonly id="o_serial_no" value="" name="o_serial_no" class="form-control">
            </div>
            <div class="mb-3 col-4">
                <label>ประเภทเครื่อง</label>
                <input type="text" readonly id="o_product_type" value="" name="o_product_type" class="form-control">
            </div>
            <div class="mb-3 col-4">
                <label>ยี่ห้อ</label>
                <input type="text" readonly id="o_brand" value="" name="o_brand" class="form-control">
            </div>
            <div class="mb-3 col-4">
                <label>รุ่น</label>
                <input type="text" readonly id="o_model" value="" name="o_model" class="form-control">
            </div>

            <div class="mb-3 col-4">
                <label>วันที่เริ่มประกัน</label>
                <input type="text" readonly id="o_warranty_start_date" value="" name="o_warranty_start_date" class="form-control">
            </div>

            <div class="mb-3 col-4">
                <label>วันที่หมดประกัน</label>
                <input type="text" readonly id="o_warranty_expire_date" value="" name="o_warranty_expire_date" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary btn-sm" type="button" id="submit" onclick="Submit()">บันทึก</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });



    });


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

    function Submit() {

        var overhaul_id = $('#overhaul_id').val();
        var formData = new FormData($("#form-add_overhaul")[0]);
        if (overhaul_id == '') {
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

            $.ajax({
                type: 'POST',
                url: 'ajax/CM_view/overhaul/Add.php',
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
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');


                        $(".tab_head").removeClass("active");
                        $(".tab_head h4").removeClass("font-weight-bold");
                        $(".tab_head h4").addClass("text-muted");
                        $(".tab-pane").removeClass("show");
                        $(".tab-pane").removeClass("active");
                        $("#tab_head_9").children("h4").removeClass("text-muted");
                        $("#tab_head_9").children("h4").addClass("font-weight-bold");
                        $("#tab_head_9").addClass("active");

                        current_fs = $(".active");

                        // next_fs = $(this).attr('id');
                        // next_fs = "#" + next_fs + "1";


                        $('#tab-9').addClass("active");

                        current_fs.animate({}, {
                            step: function() {
                                current_fs.css({
                                    'display': 'none',
                                    'position': 'relative'
                                });
                                next_fs.css({
                                    'display': 'block'
                                });
                            }
                        });
                        window.location.reload();


                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });




    }
</script>