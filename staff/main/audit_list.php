<?php include 'header2.php';

$url = '../asset/peaberry.jpg';

$user_id;

$sql = "SELECT * FROM tbl_audit_checklist WHERE active_status ='1'";
$res = mysqli_query($connect_db, $sql);
$count_list = mysqli_num_rows($res);

?>

<div class="mt-2"></div>
<style>
    .container {
        background-color: #fff;
    }

  
</style>

<body>
    <div class="container">
        <div class="row">
            <input type="text" hidden id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>">
        </div>

        <div class="row m-0 p-1">
            <div class="col-12 p-2">
                <h2>รายการ Audit</h2>
              
                    <?php
                    for ($i = 0; $i < $count_list; $i++) {
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                            <h1></h1>
                            <fieldset>
                                <label><?php echo $row['checklist_name']; ?></label>
                                <?php
                                $sql_list = "SELECT * FROM tbl_audit_score WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
                                $res_list = mysqli_query($connect_db, $sql_list);
                                while ($row_list = mysqli_fetch_assoc($res_list)) {
                                ?>
                                    <div class="form-check">
                                        <input class="form-check-input" name="score<?php echo $i; ?>" type="radio" value="1" id="flexCheckDefault<?php echo $i; ?>" >
                                        <label class="form-check-label" for="flexCheckDefault<?php echo $i; ?>">
                                            <?php echo $row_list['score_name']; ?>
                                        </label>
                                    </div>
                                <? } ?>
                            </fieldset>
                    <?php
                            if ($i > 200) {
                                exit;
                            }
                        }
                    } ?>
      
            </div>
        </div>
</body>

<!-- </div> -->
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function(event, currentIndex, newIndex) {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex) {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18) {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex) {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18) {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3) {
                    $(this).steps("previous");
                }
            },
            onFinishing: function(event, currentIndex) {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
            errorPlacement: function(error, element) {
                element.before(error);
            },
            rules: {
                confirm: {
                    equalTo: "#password"
                }
            }
        });
    });

    function SubmitForm() {

    }
</script>