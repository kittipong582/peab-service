<?php include 'header2.php'; ?>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>ยืนยันรับ</h2>
        </center>
    </div>
</div>

<div class="p-1">
    <div class="my-3">
        <!-- <input type="text" class="form-control date text-center" name="date" id="date" readonly onchange="Getdata();"> -->
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
                        <input class="form-control datepicker" type="text" name="start_date" id="start_date"
                            value="<?php echo date('d/m/Y',strtotime('-1 month')); ?>" readonly>
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
                        <input class="form-control datepicker" type="text" name="end_date" id="end_date"
                            value="<?php echo date('d/m/Y'); ?>" readonly>
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

$(".select2").select2({});

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
        url: "ajax/confirm_import/Getdata.php",
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
</script>