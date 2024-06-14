<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$group_id = mysqli_real_escape_string($connect_db, $_POST['group_id']);
$job_id = mysqli_real_escape_string($connect_db, $_POST['job_id']);

$sql_audit_id = "SELECT a.* , b.signature_image FROM tbl_job_audit a JOIN tbl_job_audit_group b ON a.group_id = b.group_id WHERE a.group_id = '$group_id' AND a.job_id ='{$job_id}'";
$res_audit_id = mysqli_query($connect_db, $sql_audit_id);

$total_score = 0;

?>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-hover">
        <?php
        while ($row_audit_id = mysqli_fetch_assoc($res_audit_id)) {
            $signature_image = $row_audit_id['signature_image'];
            $sql_topic = "SELECT * 
                                FROM tbl_audit_form a
                                LEFT JOIN tbl_audit_topic b ON a.audit_id = b.audit_id WHERE a.audit_id = '{$row_audit_id['audit_id']}' ORDER BY b.create_datetime ASC";
            $res_topic = mysqli_query($connect_db, $sql_topic);

            /// get form record //
            $sql_sum_score = "SELECT SUM(score) AS score , job.audit_id  
            FROM tbl_audit_record rec
            LEFT JOIN tbl_job_audit job ON rec.job_id = job.job_id 
            WHERE rec.job_id ='$job_id' ";
            $res_sum_score = mysqli_query($connect_db, $sql_sum_score);
            $row_sum_score = mysqli_fetch_assoc($res_sum_score);

            $total_score += $row_sum_score['score'];

            while ($row_topic = mysqli_fetch_assoc($res_topic)) {
                $sql_checklist2 = "SELECT * FROM tbl_audit_checklist a
                                WHERE a.topic_id = '{$row_topic['topic_id']}'  ORDER BY a.create_datetime ASC";
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
                                        WHERE checklist.topic_id = '{$row_topic['topic_id']}' AND record.job_id ='{$job_id}' ORDER BY checklist.create_datetime ASC";
                    $res_checklist = mysqli_query($connect_db, $sql_checklist);
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
                                <button class="btn btn-info btn-sm btn-block" onclick="ModalImage('<?php echo $row_checklist['record_id']; ?>')">รูปภาพ</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        <?php }
        }
        ?>
        <tfoot>
            <tr>
                <?php $sql_dd = "SELECT a.*,b.audit_name FROM tbl_job_audit a
                                    JOIN tbl_audit_form b ON a.audit_id = b.audit_id
                                    WHERE a.group_id ='$group_id'";
                $res_dd = mysqli_query($connect_db, $sql_dd);

                ?>
                <td>
                    <!-- <select class="form-control select2" name="job_id" id="job_id" onchange="GetForm()">

                                            <?php while ($row_dd = mysqli_fetch_assoc($res_dd)) { ?>
                                                <option value="<?php echo $row_dd['job_id'] ?>">
                                                    <?php echo $row_dd['audit_name'] ?>
                                                </option>

                                            <?php } ?>
                                        </select> -->
                </td>
                <td colspan="2">
                    คะแนนรวม :
                    <?php echo $row_sum_score['score']; ?> คะแนน
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<div>
    <label for="">ลายเซ็นลูกค้า</label>
    <img src="<?php echo ($signature_image != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $signature_image : 'upload/no-img.png' ?>" width="50%" style="border: 1wpx solid #000;" />
</div>