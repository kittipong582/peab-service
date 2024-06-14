<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$job_income_id = $_POST['job_income_id'];

$sql = "SELECT a.*,b.description FROM tbl_job_income a
LEFT JOIN tbl_income_type b ON a.income_type_id = b.income_type_id
 WHERE a.job_income_id = '$job_income_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$sql_income = "SELECT * FROM tbl_income_type WHERE active_status = 1";
$result_income  = mysqli_query($connect_db, $sql_income);

?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>
<form action="" method="post" id="form-add_income" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <div class="col-6 mb-3">
                <label for="expend_type">
                    ประเภทรายได้
                </label>
                <select class="form-control select2" id="income_type_id" style="width: 100%;" onchange="get_des(this.value)" name="income_type_id">
                    <option value="">กรุณาเลือกประเภท</option>
                    <?php while ($row_income = mysqli_fetch_array($result_income)) { ?>
                        <option value="<?php echo $row_income['income_type_id'] ?>" <?php if ($row_income['income_type_id'] == $row['income_type_id']) {
                                                                                        echo "SELECTED";
                                                                                    } ?>><?php echo "[".$row_income['income_code']."] - ".$row_income['income_type_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-6 mb-3" id="show_des">
            <label></label><br>
<label style="padding-top: 5px;"><?php echo $row['description'] ?></label>
            </div>

            <div class="col-6 mb-3">
                <label for="quantity">
                    จำนวน
                </label>
                <input type="text" class="form-control" id="quantity" value="<?php echo $row['quantity'] ?>" name="quantity">
            </div>

            <div class="col-6 mb-3">
                <label for="amount">
                    ราคาต่อหน่วย
                </label>
                <input type="text" class="form-control" id="amount" value="<?php echo $row['quantity'] * $row['income_amount'] ?>" name="amount">
            </div>



        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

    });

    function get_des(income_id) {
        $.ajax({
            url: 'ajax/mywork/service/Get_des.php',
            type: 'POST',
            dataType: 'html',
            data: {
                income_id: income_id,

            },
            success: function(data) {


                $('#show_des').html(data);

            }
        });

    }

    function Submit() {

        var income_type_id = $('.income_type_id').val();

        var quantity = $('.quantity').val();
        var amount = $('.amount').val();

        var formData = new FormData($("#form-add_income")[0]);

        if (income_type_id == "" || amount == "" || quantity == "") {
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
                url: 'ajax//mywork/service/Add_job_income.php',
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
                        $("#tab_head_2").children("h4").removeClass("text-muted");
                        $("#tab_head_2").children("h4").addClass("font-weight-bold");
                        $("#tab_head_2").addClass("active");

                        current_fs = $(".active");

                        // next_fs = $(this).attr('id');
                        // next_fs = "#" + next_fs + "1";


                        $('#tab-2').addClass("active");

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
                        record_service();
                        // document.getElementById("total_service").innerHTML = data.total_service
                        // document.getElementById("td_total").innerHTML = data.total_service

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