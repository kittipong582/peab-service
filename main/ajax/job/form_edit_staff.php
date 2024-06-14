<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_type = $_POST['job_type'];

$user_level = $_SESSION['user_level'];
$i = 0;
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
                <?php $sql_staff = "SELECT * FROM tbl_job_staff a
                LEFT JOIN tbl_user b ON a.staff_id = b.user_id 
                 WHERE a.job_id = '$job_id'";
                $result_staff  = mysqli_query($connect_db, $sql_staff);
                while ($row_staff = mysqli_fetch_array($result_staff)) {
                     $branch_care_id  = $row_staff['branch_id'];

                ?>

                    <div class="row" id="row_staff_<?php echo $i ?>">
                        <div class="col-1 mb-3">
                            <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty_staff('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div class="col-9 mb-3">
                            <select class="form-control select2 mb-3" id="staff_<?php echo $i ?>" name="staff[]">
                                <option value="">กรุณาเลือกช่าง</option>
                                <?php
                                $sql = "SELECT * FROM tbl_user WHERE branch_id = '$branch_care_id' and active_status = 1";
                                $result  = mysqli_query($connect_db , $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>

                                    <option value="<?php echo $row['user_id'] ?>" <?php if ($row['user_id'] == $row_staff['staff_id']) {
                                                                                        echo 'SELECTED';
                                                                                    } ?>><?php echo $row['fullname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php $i++;
                } ?>
                <div id="staff_counter" hidden><?php echo $i; ?></div>





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
        var branch_care_id = $('#branch_care_id').val();
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