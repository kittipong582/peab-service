<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);
$job_id = mysqli_real_escape_string($connection, $_POST['job_id']);






$sql_topic = "SELECT * 
FROM tbl_audit_form a
LEFT JOIN tbl_audit_topic b ON a.audit_id = b.audit_id WHERE a.audit_id = '$audit_id'";
$res_topic = mysqli_query($connection, $sql_topic);


$sql_head = "SELECT * FROM tbl_audit_form a
LEFT JOIN tbl_audit_topic b ON a.audit_id = b.audit_id WHERE a.audit_id = '$audit_id'";
$res_head = mysqli_query($connection, $sql_head);
$row_head = mysqli_fetch_assoc($res_head);


?>

<h3>
    <?php echo $row_head['audit_name'] ?>
</h3>
<table class="table table-bordered table-hover">

    <?php
    while ($row_topic = mysqli_fetch_assoc($res_topic)) {
        $sql_checklist2 = "SELECT * FROM tbl_audit_checklist a
               WHERE a.topic_id = '{$row_topic['topic_id']}'";
        $res_checklist2 = mysqli_query($connection, $sql_checklist2);
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
                   , score.score_name 
                   , record.record_id
                   FROM tbl_audit_checklist checklist
                   LEFT JOIN tbl_audit_record record ON checklist.checklist_id = record.checklist_id
                   LEFT JOIN tbl_audit_score score ON record.score = score.score AND checklist.checklist_id = score.checklist_id
                   WHERE checklist.topic_id = '{$row_topic['topic_id']}' AND record.job_id ='$job_id'";
            $res_checklist = mysqli_query($connection, $sql_checklist);
            while ($row_checklist = mysqli_fetch_assoc($res_checklist)) {
                ?>
                <tr>
                    <td style="width: 60%;">
                        <?php echo $row_checklist['checklist_name']; ?>
                    </td>
                    <td>
                      

                    <?php echo $row_checklist['score_name']; ?>

                    </td>
                    <td style="width: 5%;">
                        <button class="btn btn-info btn-sm btn-block"
                            onclick="GetModalPic('<?php echo $row_checklist['record_id']; ?>')">รูปภาพ</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
    <tfoot>
        <?php
        $sql_sum_score = "SELECT SUM(score) AS score FROM tbl_audit_record WHERE job_id ='$job_id' ";
        $res_sum_score = mysqli_query($connection, $sql_sum_score);
        $row_sum_score = mysqli_fetch_assoc($res_sum_score);


        ?>
        <tr>
            <td></td>
            <td colspan="2">คะแนนรวม :
                <?php echo $row_sum_score['score'] ?> คะแนน
            </td>
        </tr>
    </tfoot>
</table>