<?php include 'header2.php'; ?>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>ยืนยันโอนย้าย</h2>
        </center>
    </div>
</div>

<div class="p-1">
    <div class="my-3">

        <div class="row">
            <div class="col-6">
                <label> <input type="checkbox" class="i-checks" id="chk" name="chk" value="x" onchange="Getdate();">
                    แสดงทั้งหมด
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-6" id="get_start_date">
                <div class="form-group">
                    <label> ตั้งแต่</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="col-6" id="get_end_date">
                <div class="form-group">
                    <label> ถึง</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <input class="btn btn-sm btn-info btn-block" type="button" onclick="Getdata();" value="แสดงข้อมูล">
            </div>
        </div>

    </div>

    <div id="show_data"></div>

</div>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#get_start_date').hide();
        $('#get_end_date').hide();
        Getdate();
        Getdata();
    });

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    });

    function Getdate() {

        $("#chk").val(function() {
            if (this.checked) {
                $('#get_start_date').show();
                $('#get_end_date').show();
            } else {
                $('#get_start_date').hide();
                $('#get_end_date').hide();
            }
        });

    }

    function Getdata() {

        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        num_chk = 0;
        $("#chk").change(function() {
            if (this.checked) {
                num_chk = 1;
            } else {
                num_chk = 2;
            }
            $("#chk").val(num_chk);
        });

        var chk = $("#chk").val();
        // alert(chk);

        $.ajax({
            type: 'POST',
            url: "ajax/confirm_transfer/Getdata.php",
            data: {
                start_date: start_date,
                end_date: end_date,
                chk: chk
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
            }
        });
    }

    function submit_approve() {

        var transfer_id = $('#transfer_id').val();
        var remark = $('#remark').val();

        var formData = new FormData($("#frm_confirm")[0]);

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
                url: 'ajax/confirm_transfer/update_transfer.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {

                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#Modal').modal('hide');
                        $('.modal-backdrop').remove();
                        Getdata();
                        // location.reload();
                    }
                }
            })
        });
    }


    function submit_cancel() {

        var transfer_id = $('#transfer_id').val();
        var remark = $('#remark').val();

        var formData = new FormData($("#frm_confirm")[0]);

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
                url: 'ajax/confirm_transfer/cancel_transfer.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {

                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#Modal').modal('hide');
                        Getdata();
                        // location.reload();
                    }
                }
            })
        });
    }
</script>