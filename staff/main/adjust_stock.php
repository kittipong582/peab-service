<?php include 'header2.php'; ?>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>ปรับสต๊อก</h2>
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
            <div class="col-12 form-group" id="show_data_button">
                <input class="btn btn-sm btn-info btn-block" type="button" onclick="Getdata();" value="แสดงข้อมูล">
            </div>

            <div class="col-12">
                <input class="btn btn-sm btn-primary btn-block" type="button" onclick="Modal_adjust();" value="ทำรายการ">
            </div>
        </div>

    </div>

    <div id="show_data"></div>

</div>

<!-- <div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div> -->

<div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#get_start_date').hide();
        $('#get_end_date').hide();
        $('#show_data_button').hide();
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
                $('#show_data_button').show();
            } else {
                $('#get_start_date').hide();
                $('#get_end_date').hide();
                $('#show_data_button').hide();
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
            url: "ajax/adjust_stock/Getdata.php",
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


    function Modal_adjust() {

        $.ajax({
            type: "post",
            url: "ajax/adjust_stock/modal_adjust.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });

    }


    function modal_approve(adjust_id, result) {
        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/adjust_stock/approve.php",
                data: {
                    adjust_id: adjust_id,
                    result: result
                },
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 500
                        }, function() {
                            swal.close();
                            Getdata();
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }
</script>