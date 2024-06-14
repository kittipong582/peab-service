<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$approve_user_id = $_SESSION['user_id'];
$job_id = $_GET['id'];


$sql = "SELECT a.job_no,a.job_type,b.product_type,c.* FROM tbl_job a 
LEFT JOIN tbl_product b ON a.product_id = b.product_id
LEFT JOIN tbl_pmin_form c ON a.job_id = c.job_id
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);


///////column 
$sql_form = "SELECT * FROM tbl_technical_form WHERE job_type ='{$row['job_type']}' AND product_type = '{$row['product_type']}' AND list_order BETWEEN '1' and '16'  ORDER BY list_order";
$result_form  = mysqli_query($connection, $sql_form);


///////column 1
$sql_form1 = "SELECT * FROM tbl_technical_form WHERE job_type ='{$row['job_type']}' AND product_type = '{$row['product_type']}' AND list_order BETWEEN '17' and '32'  ORDER BY list_order";
$result_form1  = mysqli_query($connection, $sql_form1);

?>
<style>
    .underline {
        border: 0;
        outline: 0;
        background: transparent;
        border-bottom: 0.5px solid black;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $row['job_no'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="job_list.php">รายการงาน</a>
            </li>
            <li class="breadcrumb-item">
                <a href="view_cm.php?id=<?php echo $job_id; ?>"><?php echo $row['job_no'] ?></a>
            </li>

            <li class="breadcrumb-item active">
                <strong>Technical Form</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-title">

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class='col-6 mb-3'>
                                <div class="row">
                                    <?php
                                    $i = 1;
                                    while ($row_form = mysqli_fetch_array($result_form)) {

                                        $choice_num = 'choice_no' . $i;

                                        $before_remark = 'no_' . $i . '_before';
                                        $after_remark = 'no_' . $i . '_after';
                                        $no_detail = 'no' . $i . "_detail";


                                        if ($row_form['form_type'] == '1' && $row_form['have_remark'] == '0') {

                                    ?>
                                            <div class="col-6 mb-3">
                                                <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="input-group">
                                                    <?php if ($row[$choice_num] == 1) {
                                                        echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                    } else {
                                                        echo "<span> </span>";
                                                    } ?><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice1'] ?></label>
                                                      <?php if ($row[$choice_num] == 2) {
                                                            echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                        } else {
                                                            echo "<span> </span>";
                                                        } ?><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice2'] ?> </label>
                                                </div>
                                            </div>

                                        <?php } else if ($row_form['form_type'] == '1' && $row_form['have_remark'] == '1') {

                                        ?>

                                            <div class="col-6 mb-3">
                                                <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <?php if ($row[$choice_num] == 1) {
                                                    echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                } else {
                                                    echo "<span> </span>";
                                                } ?><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form['choice1'] ?> </label><br>
                                                <?php if ($row[$choice_num] == 2) {
                                                    echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                } else {
                                                    echo "<span> </span>";
                                                } ?><label style="font-size: 13px;padding-right: 10px;padding-left: 10px; "> <?php echo $row_form['choice2'] ?> </label>
                                                <input type="text" readonly class="underline" style="padding-right: 10px;padding-left: 10px;" id="no<?php echo $i ?>_detail" name="no<?php echo $i ?>_detail" value="<?php echo $row[$no_detail] ?>">
                                            </div>

                                        <?php  } else if ($row_form['form_type'] == '2') {

                                        ?>
                                            <div class="col-6 mb-3">
                                                <?php echo $row_form['list_order'] . "." . $row_form['form_name'] ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label style="font-size: 13px;"> <?php echo $row_form['choice1'] ?> </label><input type="text" readonly class="underline" style="padding-right: 10px;padding-left: 10px;" id="no<?php echo $i ?>_before" value="<?php echo $row[$before_remark] ?>" name="no<?php echo $i ?>_before">
                                                <label style="font-size: 13px; "> <?php echo $row_form['choice2'] ?> </label><input type="text" readonly class="underline" style="padding-right: 10px;padding-left: 10px;" id="no<?php echo $i ?>_after" value="<?php echo $row[$after_remark] ?>" name="no<?php echo $i ?>_after">
                                            </div>

                                    <?php  }
                                        $i++;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="row">
                                    <?php
                                    $i = 17;
                                    while ($row_form1 = mysqli_fetch_array($result_form1)) {


                                        $choice_num = 'choice_no' . $i;

                                        $before_remark = 'no_' . $i . '_before';
                                        $after_remark = 'no_' . $i . '_after';
                                        $no_detail = 'no' . $i . "_detail";


                                        if ($row_form1['form_type'] == '1' && $row_form1['have_remark'] == '0') {

                                    ?>
                                            <div class="col-6 mb-3">
                                                <?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="input-group">
                                                    <?php if ($row[$choice_num] == 1) {
                                                        echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                    } else {
                                                        echo "<span> </span>";
                                                    } ?> </span><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form1['choice1'] ?></label>
                                                      <?php if ($row[$choice_num] == 2) {
                                                            echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                        } else {
                                                            echo "<span> </span>";
                                                        } ?><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form1['choice2'] ?> </label>
                                                </div>
                                            </div>

                                        <?php } else if ($row_form1['form_type'] == '1' && $row_form1['have_remark'] == '1') {

                                        ?>

                                            <div class="col-6 mb-3">
                                                <?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <?php if ($row[$choice_num] == 1) {
                                                    echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                } else {
                                                    echo "<span> </span>";
                                                } ?><label style="font-size: 13px; padding-right: 10px;padding-left: 10px;"> <?php echo $row_form1['choice1'] ?> </label><br>
                                                <?php if ($row[$choice_num] == 2) {
                                                    echo "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";
                                                } else {
                                                    echo "<span> </span>";
                                                } ?><label style="font-size: 13px;padding-right: 10px;padding-left: 10px; "> <?php echo $row_form1['choice2'] ?> </label>
                                                <input type="text" readonly class="underline" style="padding-right: 10px;padding-left: 10px;" id="no<?php echo $i ?>_detail" name="no<?php echo $i ?>_detail" value="<?php echo $row[$no_detail] ?>">
                                            </div>

                                        <?php  } else if ($row_form1['form_type'] == '2') {

                                        ?>
                                            <div class="col-6 mb-3">
                                                <?php echo $row_form1['list_order'] . "." . $row_form1['form_name'] ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label style="font-size: 13px;"> <?php echo $row_form1['choice1'] ?> </label><input type="text" readonly class="underline" style="padding-right: 10px;padding-left: 10px;" id="no<?php echo $i ?>_before" name="no<?php echo $i ?>_before" value="<?php echo $row[$before_remark] ?>">
                                                <label style="font-size: 13px; "> <?php echo $row_form1['choice2'] ?> </label><input type="text" readonly class="underline" style="padding-right: 10px;padding-left: 10px;" id="no<?php echo $i ?>_after" name="no<?php echo $i ?>_after" value="<?php echo $row[$before_remark] ?>">
                                            </div>

                                    <?php  }
                                        $i++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $('.icheckbox_square-green').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',

        });

    });
</script>