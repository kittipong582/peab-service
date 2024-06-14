<?php

include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_customer_branch e ON a.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);



?>

<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>

<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการอะไหล่</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <!-- <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="group_id" name="group_id" value="<?php echo $row['customer_group'] ?>" type="hidden">
            <input id="responsible_user_id" name="responsible_user_id" value="<?php echo $row['responsible_user_id'] ?>" type="hidden">
            <div class="col-mb-3 col-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:5%;"></th>
                            <th style="width:5%;">ประกัน</th>
                            <th style="width:20%;" class="text-center">อะไหล่</th>
                            <th style="width:10%;" class="text-center">on hand</th>
                            <th style="width:10%;" class="text-center">จำนวนใช้</th>
                        </tr>
                    </thead>
                    <tbody id="Addform" name="Addform">
                        <div id="counter" hidden>0</div>

                    </tbody>
                </table>
            </div>

            <div class="col-md-12 mb-3">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row();"><i class="fa fa-plus"></i>
                    เพิ่มรายการ
                </button>
            </div>
        </div> -->
        <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
        <input id="group_id" name="group_id" value="<?php echo $row['customer_group'] ?>" type="hidden">
        <input id="responsible_user_id" name="responsible_user_id" value="<?php echo $row['responsible_user_id'] ?>" type="hidden">

        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="form-group">
                <div class="row">
                    <label><strong>เพิ่มข้อมูลอะไหล่ </strong></label>
                </div><br>
                <div id="Addform_sparepart" name="Addform_sparepart">
                </div>
                <div id="counter" hidden>0</div>
                <br>

                <div class="row">
                    <!-- <div class="col-md-12"> -->
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row2();"><i class="fa fa-plus"></i>
                        เพิ่มรายการ
                    </button>
                    <!-- </div> -->
                </div>
               
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        <button class="btn btn-primary" type="button" id="submit" onclick="Submit_sparepart()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        add_row2();

    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    function select_part(part_id, i,branch_id) {

        var group_id = $('#group_id').val();
        

        $.ajax({
            url: 'ajax/mywork/sparepart/Get_part.php',
            type: 'POST',
            dataType: 'json',
            data: {
                part_id: part_id,
                group_id: group_id,
                branch_id: branch_id
            },
            success: function(data) {

                $('#Onhand_' + i).val(data.remain_stock);
                $('#cost_' + i).val(data.unit_price);

            }
        });

    }


    // function add_row() {
    //     $('#counter').html(function(i, val) {
    //         return +val + 1
    //     });

    //     var job_id = $('#job_id').val();
    //     var increment = $('#counter').html();
    //     $.ajax({
    //         url: 'ajax/mywork/sparepart/Add_row_spare.php',
    //         type: 'POST',
    //         dataType: 'html',
    //         data: {
    //             rowCount: increment,
    //             job_id: job_id
    //         },
    //         success: function(data) {

    //             $('#Addform').append(data);
    //             $(".select2").select2({
    //                 width: "100%"
    //             });
    //             $('#chkbox_' + increment).iCheck({
    //                 checkboxClass: 'icheckbox_square-green',
    //                 radioClass: 'iradio_square-green',
    //             }).on('ifChanged', function(e) {
    //                 if ($('#chkbox_' + increment).is(':checked') == true) {
    //                     $('#insurance_status_' + increment).val('1');
    //                 } else {
    //                     $('#insurance_status_' + increment).val('0');
    //                 }
    //             });
    //         }
    //     });
    // }

    // function desty(i) {
    //     document.getElementById('tr_' + i).remove();
    // }

    function add_row2() {
        $('#counter').html(function(i, val) {
            return +val + 1
        });
        var job_id = $('#job_id').val();
        var increment = $('#counter').html();
        $.ajax({
            url: 'ajax/mywork/sparepart/add_row2.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
                job_id: job_id
            },
            success: function(data) {

                $('#Addform_sparepart').append(data);
                $(".select2").select2({
                    width: "100%"
                });
                $('#chkbox_' + increment).iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                }).on('ifChanged', function(e) {
                    if ($('#chkbox_' + increment).is(':checked') == true) {
                        $('#insurance_status_' + increment).val('1');
                    } else {
                        $('#insurance_status_' + increment).val('0');
                    }
                });
            }
        });
    }

    function desty2(i) {
        document.getElementById('div_' + i).remove();
    }


    function Submit_sparepart() {

        var spare_part = $('.spare_part').val();
        var quantity = $('.quantity').val();
        var Onhand = $('.Onhand').val();

        var formData = new FormData($("#form-add_spare")[0]);

        if (spare_part == "" || quantity == "" || Onhand == "") {
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
                url: 'ajax/mywork/sparepart/Add_spare_part.php',
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

                        // $(".tab_head").removeClass("active");
                        // $(".tab_head h4").removeClass("font-weight-bold");
                        // $(".tab_head h4").addClass("text-muted");

                        // $(".tab-pane").removeClass("show");
                        // $(".tab-pane").removeClass("active");
                        // $("#tab_head_1").children("h4").removeClass("text-muted");
                        // $("#tab_head_1").children("h4").addClass("font-weight-bold");
                        // $("#tab_head_1").addClass("active");

                        // current_fs = $(".active");

                        // // next_fs = $(this).attr('id');
                        // // next_fs = "#" + next_fs + "1";

                        // // $(".tab_head").removeClass("show");
                        // $('#tab-1').addClass("active");

                        // current_fs.animate({}, {
                        //     step: function() {
                        //         current_fs.css({
                        //             'display': 'none',
                        //             'position': 'relative'
                        //         });
                        //         next_fs.css({
                        //             'display': 'block'
                        //         });
                        //     }
                        // });
                        record_sparepart();
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'จำนวนอะไหล่ไม่พอ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>