<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$user_level = $_SESSION['user_level'];
?>

<?php if ($user_level != 1 && $user_level != 2) { ?>
    <div class="mb-3 col-12">
        <div class="row">
            <div class="col-3">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row_staff();"><i class="fa fa-plus"></i>
                    เพิ่มคนงาน
                </button>
            </div>
            <div class="col-9" id="Add_staff_form" name="Add_staff_form">
                <div id="staff_counter" hidden>0</div>




            </div>
        </div>


    </div>
<?php } ?>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {


    });

    function desty(i) {
        document.getElementById('tr_' + i).remove();
    }


    function add_row_staff() {

        $('#staff_counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#staff_counter').html();
        var branch_care_id = $('#branch_care_id').val() || $('#current_branch_care').val();

        $.ajax({
            url: 'ajax/job/Add_row_staff.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
                branch_care_id: branch_care_id
            },
            success: function(data) {

                $('#Add_staff_form').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }
</script>