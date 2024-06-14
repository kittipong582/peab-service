<?php
session_start();
@include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

/// get form record //
$user = mysqli_real_escape_string($connect_db, $_POST['user']);
$branch = mysqli_real_escape_string($connect_db, $_POST['branch']);
$page = mysqli_real_escape_string($connect_db, $_POST['page']);
$job = mysqli_real_escape_string($connect_db, $_POST['job']);

$next_page = $page + 1;

$sql_audit_id = "SELECT * FROM tbl_job_audit WHERE job_id = '$job'";
$res_audit_id = mysqli_query($connect_db, $sql_audit_id);
$row_audit_id = mysqli_fetch_assoc($res_audit_id);

$sql_topic = "SELECT * 
FROM tbl_audit_form a
LEFT JOIN tbl_audit_topic b ON a.audit_id = b.audit_id WHERE a.audit_id = '{$row_audit_id['audit_id']}' ORDER BY b.create_datetime ASC";
$res_topic = mysqli_query($connect_db, $sql_topic);

/// get form record //

$sql_sum_score = "SELECT SUM(score) AS score FROM tbl_audit_record WHERE job_id ='$job' ";
$res_sum_score = mysqli_query($connect_db, $sql_sum_score);
$row_sum_score = mysqli_fetch_assoc($res_sum_score);

?>

<table class="table table-bordered table-hover">

    <?php
    while ($row_topic = mysqli_fetch_assoc($res_topic)) {
        $sql_checklist2 = "SELECT * FROM tbl_audit_checklist a
               WHERE a.topic_id = '{$row_topic['topic_id']}' ORDER BY a.create_datetime ASC";
        $res_checklist2 = mysqli_query($connect_db, $sql_checklist2);
        $row_checklist2 = mysqli_fetch_assoc($res_checklist2);
    ?>
        <thead>
            <tr>
                <td colspan="3">
                    <?php echo $row_topic['topic_datail'] ?>
                </td>
            </tr>

        </thead>
        <tbody>
            <?php
            $sql_checklist = "SELECT 
                   checklist.checklist_name
                   , record.score 
                   , record.record_id 
                   , score.score_name 
                   FROM tbl_audit_checklist checklist
                   LEFT JOIN tbl_audit_record record ON checklist.checklist_id = record.checklist_id
                   LEFT JOIN tbl_audit_score score ON record.score = score.score AND checklist.checklist_id = score.checklist_id
                   WHERE checklist.topic_id = '{$row_topic['topic_id']}' AND record.job_id ='$job' ORDER BY checklist.create_datetime ASC";
            $res_checklist = mysqli_query($connect_db, $sql_checklist);
            while ($row_checklist = mysqli_fetch_assoc($res_checklist)){
            ?>
            <tr>
                <td style="width: 60%;">
                    <?php echo $row_checklist['checklist_name']; ?>
                </td>
                <td>
                    <?php echo $row_checklist['score_name']; ?>
                </td>
                <td style="width: 5%;">
                    <button class="btn btn-info btn-sm btn-block" onclick="ModalImage('<?php echo $row_checklist['record_id']; ?>')">รายละเอียด</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
    <tfoot>
        <tr>
            <td></td>
            <td colspan="2">คะแนนรวม : <?php echo $row_sum_score['score']; ?> คะแนน</td>
        </tr>
    </tfoot>
</table>

<input type="hidden" id="sum_score" name="sum_score" value="<?php echo $row_sum_score['score']; ?>">
<input type="hidden" id="close_audit" name="close_audit" value="<?php echo date("Y-m-d H:i:s"); ?>">
<input type="hidden" id="job_id" name="job_id" value="<?php echo $job; ?>">
<input type="hidden" id="group_id" name="group_id" value="<?php echo $row_audit_id['group_id']; ?>">


<div class="row">
    <div class="col text-left">
        <?php if ($page !=  1) { ?>
            <button class="btn btn-success btn-lg w-100" onclick="GetForm('<?php echo $page - 1 ?>')">ย้อนกลับ</button>
        <?php } ?>
    </div>
    <div class="col text-right">
        <button class="btn btn-primary btn-lg w-100" onclick="SubmitChecklistHead()">บันทึก</button>
    </div>
</div>