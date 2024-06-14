<?php include 'header2.php'; ?>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>บันทึกการฝาก</h2>
        </center>
    </div>
</div>

<div class="p-1">
    <div class="row">
        <div class="col-5 mb-1">

            <input type="text" class="form-control datepicker text-center" name="start_date" id="start_date" value="<?php echo date("d/m/Y", strtotime("now -7 days")); ?>" readonly onchange="Getdata();">

        </div>
        <div class="col-2 mb-1">
            <center><label style="padding-top: 1ex;"><b> ถึง </b></label></center>
        </div>
        <div class="col-5 mb-1">

            <input type="text" class="form-control datepicker text-center" name="end_date" id="end_date" value="<?php echo date("d/m/Y", strtotime("now +7 days")); ?>" readonly onchange="Getdata();">

        </div>

        <?php if ($user_level == 2) { ?>
            <div class="col-12 mb-3">

                <label>ช่าง</label>
                <select class="form-control select2" id="user_id" name="user_id">

                    <option value="x">ทั้งหมด</option>
                    <?php $sql_staff = "SELECT * FROM tbl_user WHERE user_level = 1 AND branch_id = '$branch_id'";
                    $rs_staff = mysqli_query($connect_db, $sql_staff) or die($connect_db->error);

                    while ($row_staff = mysqli_fetch_assoc($rs_staff)) { ?>

                        <option value="<?php echo $row_staff['user_id']; ?>"><?php echo $row_staff['fullname'] ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>

        <div class="col-12 mb-1">

            <button class="btn btn-success btn-block btn-sm" onclick="Getdata()">ค้นหา</button>
        </div>
    </div>
    <div id="show_data"></div>

</div>



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

        Getdata();
        $(".select2").select2({});

        $('.datepicker').datepicker({
            // startView: 0,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy",

        });
    });



    function Getdata() {

        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var user_id = $('#user_id').val();

        $.ajax({
            type: 'POST',
            url: "ajax/payment_transfer/Getdata.php",
            data: {
                first_date: start_date,
                end_date: end_date,
                user_id: user_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('#tbl_deposit').DataTable({
                    pageLength: 25,
                    responsive: true
                    // sorting: disable
                });
            }
        });
    }


    function Modal_transfer() {

        $.ajax({
            type: "post",
            url: "ajax/transfer/modal_transfer.php",
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


    function add_row(user_id) {

        $('#counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#counter').html();

        $.ajax({
            url: 'ajax/transfer/add_row.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
                user_id: user_id
            },
            success: function(data) {

                $('#Addform_transfer').append(data);
                $(".select2").select2({
                    width: "150px"
                });
            }
        });
    }
</script>