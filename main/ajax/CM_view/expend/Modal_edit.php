<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_expend_id = $_POST['job_expend_id'];


$sql = "SELECT * FROM tbl_job_expend a
LEFT JOIN tbl_expend_type b ON a.expend_type_id = b.expend_type_id
 WHERE a.job_expend_id = '$job_expend_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);



$sql_expend = "SELECT * FROM tbl_expend_type WHERE active_status = 1";
$result_expend  = mysqli_query($connect_db, $sql_expend);

?>
<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="job_expend_id" name="job_expend_id" value="<?php echo $job_expend_id ?>" type="hidden">
            <div class="col-6 mb-3">
                <label for="expend_type">
                    ประเภทค่าใช้จ่าย
                </label>
                <select class="form-control select2" id="expend_type_id" style="width: 100%;" onchange="get_des(this.value)" name="expend_type_id">
                    <option value="">กรุณาเลือกประเภท</option>
                    <?php while ($row_expend = mysqli_fetch_array($result_expend)) { ?>
                        <option value="<?php echo $row_expend['expend_type_id'] ?>" <?php if ($row['expend_type_id'] == $row_expend['expend_type_id']) {
                                                                                        echo "SELECTED";
                                                                                    } ?>><?php echo $row_expend['expend_type_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-6 mb-3" id="show_des">
                <label></label><br>
                <label style="padding-top: 5px;"><?php echo $row['description'] ?></label>

            </div>

            <div class="col-6 mb-3">
                <label for="amount">
                    ยอดรวม
                </label>
                <input type="text" class="form-control" id="amount" value="<?php echo $row['expend_amount'] ?>" name="amount">
            </div>

            <div class="col-6 mb-3" id="show_des">

            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_Expend()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});

    });

    function get_des(expend_id) {
        $.ajax({
            url: 'ajax/CM_view/expend/Get_des.php',
            type: 'POST',
            dataType: 'html',
            data: {
                expend_id: expend_id,

            },
            success: function(data) {


                $('#show_des').html(data);

            }
        });

    }

    function Update_Expend() {

        var expend_type_id = $('.expend_type_id').val();
        var amount = $('.amount').val();

        var formData = new FormData($("#form-add_spare")[0]);

        if (expend_type_id == "" || amount == "") {
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
                url: 'ajax/CM_view/expend/update_job_expend.php',
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
                        $("#tab_head_5").children("h4").removeClass("text-muted");
                        $("#tab_head_5").children("h4").addClass("font-weight-bold");
                        $("#tab_head_5").addClass("active");

                        current_fs = $(".active");

                        // next_fs = $(this).attr('id');
                        // next_fs = "#" + next_fs + "1";


                        $('#tab-5').addClass("active");

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
                        load_table_expend();
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