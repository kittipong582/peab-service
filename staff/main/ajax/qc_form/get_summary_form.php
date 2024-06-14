<?php
session_start();
include ("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

/// get form record //
$user = mysqli_real_escape_string($connect_db, $_POST['user']);
$branch = mysqli_real_escape_string($connect_db, $_POST['branch']);
$page = mysqli_real_escape_string($connect_db, $_POST['page']);
$job = mysqli_real_escape_string($connect_db, $_POST['job']);
$product_type = mysqli_real_escape_string($connect_db, $_POST['product_type']);

$next_page = $page + 1;

$sql_qc_id = "SELECT * FROM tbl_job_qc WHERE job_qc_id = '$job'";
$res_qc_id = mysqli_query($connect_db, $sql_qc_id);
$row_qc_id = mysqli_fetch_assoc($res_qc_id);

$sql_topic = "SELECT * 
FROM tbl_qc_form a
LEFT JOIN tbl_qc_topic b ON a.qc_id = b.qc_id WHERE a.product_type_id = '{$row_qc_id['product_type_id']}' ORDER BY b.create_datetime ASC";
$res_topic = mysqli_query($connect_db, $sql_topic);

/// get form record //
$sql_sum_score = "SELECT SUM(score) AS score FROM tbl_qc_record WHERE job_qc_id ='$job' ";
$res_sum_score = mysqli_query($connect_db, $sql_sum_score);
$row_sum_score = mysqli_fetch_assoc($res_sum_score);

?>

<table class="table table-bordered table-hover">

    <?php
    while ($row_topic = mysqli_fetch_assoc($res_topic)) {
        $sql_checklist2 = "SELECT * FROM tbl_qc_checklist a
               WHERE a.topic_qc_id = '{$row_topic['topic_qc_id']}' ORDER BY a.create_datetime ASC";
        $res_checklist2 = mysqli_query($connect_db, $sql_checklist2);
        $row_checklist2 = mysqli_fetch_assoc($res_checklist2);
        ?>
        <thead>
            <tr>
                <td colspan="3">
                    <?php
                    $sql_checklist_sp = "SELECT a.checklist_name,a.checklist_id,a.topic_qc_id, b.score,b.record_id,b.text_score, c.score_name, d.topic_detail,d.topic_qc_id FROM tbl_qc_checklist a 
                                     LEFT JOIN tbl_qc_record b ON a.checklist_id = b.checklist_id 
                                     LEFT JOIN tbl_qc_score c ON b.score = c.score AND b.checklist_id = c.checklist_id
                                     LEFT JOIN tbl_qc_topic d ON d.topic_qc_id = a.topic_qc_id 
                                    WHERE b.job_qc_id = '$job' AND d.topic_qc_id = '{$row_topic['topic_qc_id']}' ORDER BY a.create_datetime ASC ";
                    $res_checklist_sp = mysqli_query($connect_db, $sql_checklist_sp);
                    $row_checklist_sp = mysqli_fetch_assoc($res_checklist_sp);
                    ?>
                    <?php
                    $sql_p = "SELECT COUNT(CASE WHEN a.score = 1 THEN 1 END) AS pass ,COUNT(CASE WHEN a.score = 0 THEN 1 END) AS fail FROM tbl_qc_record a 
                                    LEFT JOIN tbl_qc_checklist b ON a.checklist_id = b.checklist_id
                                    LEFT JOIN tbl_qc_topic c ON b.topic_qc_id =c.topic_qc_id 
                                    WHERE a.job_qc_id = '$job' AND b.topic_qc_id = '{$row_topic['topic_qc_id']}'";
                    $res_p = mysqli_query($connect_db, $sql_p);

                    while ($row_p = mysqli_fetch_assoc($res_p)) {
                        if ($row_p['fail'] == '0') {
                            echo $row_topic['topic_detail'] . ' <label class="badge badge-primary text-size"> ผ่าน</label>';
                        } else {
                            echo $row_topic['topic_detail'] . ' <label class="badge badge-danger text-size"> ไม่ผ่าน</label>';
                        }
                    }
                    ?>
                </td>
            </tr>

        </thead>
        <tbody>
            <?php
            $sql_checklist = "SELECT a.checklist_name,a.topic_qc_id, b.score,b.record_id,b.text_score, c.score_name, d.topic_detail,d.topic_qc_id FROM tbl_qc_checklist a LEFT JOIN tbl_qc_record b ON a.checklist_id = b.checklist_id LEFT JOIN tbl_qc_score c ON b.score_id = c.score_id AND b.checklist_id = c.checklist_id LEFT JOIN tbl_qc_topic d ON d.topic_qc_id = a.topic_qc_id WHERE b.job_qc_id = '$job' AND d.topic_qc_id = '{$row_topic['topic_qc_id']}' ORDER BY a.create_datetime ASC ";
            $res_checklist = mysqli_query($connect_db, $sql_checklist);
            while ($row_checklist = mysqli_fetch_assoc($res_checklist)) {
                ?>
                <tr>
                    <td style="width: 60%;">
                        <?php echo $row_checklist['checklist_name']; ?>
                    </td>
                    <td>
                        <?php echo $row_checklist['score_name']; ?>
                        <?php echo $row_checklist['text_score']; ?>
                    </td>
                    <td style="width: 5%;">
                        <button class="btn btn-info btn-sm btn-block"
                            onclick="ModalImage('<?php echo $row_checklist['record_id']; ?>')">รูปภาพ</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
    <tfoot>
        <tr>
            <td></td>
            <td class="text-center" colspan="2">
                <?php
                $sql_p_all = "SELECT COUNT(CASE WHEN a.score = 1 THEN 1 END) AS pass ,COUNT(CASE WHEN a.score = 0 THEN 1 END) AS fail FROM tbl_qc_record a 
                             LEFT JOIN tbl_qc_checklist b ON a.checklist_id = b.checklist_id
                             LEFT JOIN tbl_qc_topic c ON b.topic_qc_id =c.topic_qc_id 
                             WHERE a.job_qc_id = '$job'";
                $res_p_all = mysqli_query($connect_db, $sql_p_all);
                $row_p_all = mysqli_fetch_assoc($res_p_all);
                ?>
                <?php
                if (($row_p_all['fail'] == '0')) {
                    echo '<label class="badge badge-primary text-size"> ผ่าน</label>';
                } else {
                    echo '<label class="badge badge-danger text-size"> ไม่ผ่าน</label>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <?php
            // $sql_detail = "SELECT * FROM tbl_qc_record WHERE record_id = '{$row['record_id']}'";
            // $res_detail = mysqli_query($connection, $sql_detail) or die($connection->error);
            // $row_detail = mysqli_fetch_assoc($res_detail);
            ?>
            <td colspan="3">
                <label>หมายเหตุ</label>
                <textarea name="remark" id="remark" rows="4" cols="43" class="form-control"></textarea>
            </td>
        </tr>
    </tfoot>

</table>


<input type="text" hidden id="sum_score" name="sum_score" value="<?php echo $row_sum_score['score']; ?>">
<input type="text" hidden id="close_qc" name="close_qc" value="<?php echo date("Y-m-d H:i:s"); ?>">
<input type="text" hidden id="job_id" name="job_id" value="<?php echo $job; ?>">

<div class="row">
    <div class="col text-left">
        <?php if ($page != 1) { ?>
            <button class="btn btn-success btn-lg w-100" onclick="GetForm('<?php echo $page - 1 ?>')">ย้อนกลับ</button>
        <?php } ?>
    </div>
    <div class="col text-right">
        <button class="btn btn-primary btn-lg w-100" onclick="SubmitChecklistHead()">บันทึก</button>
    </div>
</div>