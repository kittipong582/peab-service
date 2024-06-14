<?php include 'header3.php';

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$group_id = mysqli_real_escape_string($connect_db, $_GET['group_id']);


$sql_audit_id = "SELECT a.* , b.signature_image FROM tbl_job_audit a JOIN tbl_job_audit_group b ON a.group_id = b.group_id WHERE a.group_id = '$group_id'";
$res_audit_id = mysqli_query($connect_db, $sql_audit_id);

$total_score = 0;

?>
<style>
    .container {
        background-color: #fff;
    }
</style>
<div class="container">
    <div class="row m-0 p-1">
        <div class="col-12 p-2">

            <table class="table table-bordered table-hover">

                <?php
                while ($row_audit_id = mysqli_fetch_assoc($res_audit_id)) {
                    $signature_image = $row_audit_id['signature_image'];
                    $sql_topic = "SELECT * 
                    FROM tbl_audit_form a
                    LEFT JOIN tbl_audit_topic b ON a.audit_id = b.audit_id WHERE a.audit_id = '{$row_audit_id['audit_id']}' ORDER BY b.create_datetime ASC";
                    $res_topic = mysqli_query($connect_db, $sql_topic);

                    /// get form record //

                    $sql_sum_score = "SELECT SUM(score) AS score FROM tbl_audit_record WHERE job_id ='{$row_audit_id['job_id']}' ";
                    $res_sum_score = mysqli_query($connect_db, $sql_sum_score);
                    $row_sum_score = mysqli_fetch_assoc($res_sum_score);

                    $total_score += $row_sum_score['score'];

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
                                WHERE checklist.topic_id = '{$row_topic['topic_id']}' AND record.job_id ='{$row_audit_id['job_id']}' ORDER BY checklist.create_datetime ASC";
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
                        <td></td>
                        <td colspan="2">คะแนนรวม : <?php echo $total_score; ?> คะแนน</td>
                    </tr>
                </tfoot>
            </table>
            <div>
                <label for="">ลายเซ็นลูกค้า</label>
                <img src="<?php echo ($signature_image != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $signature_image : 'upload/no-img.png' ?>" width="100%" style="border: 1px solid #000;"/>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>
<script>
    function ModalImage(record_id) {
        $("#myModal").modal("show");
        $("#showModal").load("ajax/audit_form/modal_image.php", {
            record_id: record_id
        });
    }
</script>