<?php
include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

/// get form record //
$job = mysqli_real_escape_string($connect_db, $_GET['work']);

// $sql_qc_id = "SELECT * FROM tbl_job_qc WHERE job_qc_id = '$job'";
// $res_qc_id = mysqli_query($connect_db, $sql_qc_id);
// $row_qc_id = mysqli_fetch_assoc($res_qc_id);


$sql_qc_id = "SELECT * FROM tbl_job_qc WHERE job_qc_id = '$job'";
$res_qc_id = mysqli_query($connect_db, $sql_qc_id);

?>
<style>
    .container {
        background-color: #fff;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงานผล QC</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="qc_list.php">รายการงาน QC</a>
            </li>
            <li class="breadcrumb-item active">
                <a>รายงานผล</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">

                                <?php
                                while ($row_qc_id = mysqli_fetch_assoc($res_qc_id)) {
                                    $sql_topic = "SELECT * 
    FROM tbl_qc_form a
    LEFT JOIN tbl_qc_topic b ON a.qc_id = b.qc_id WHERE a.product_type_id = '{$row_qc_id['product_type_id']}' ORDER BY b.create_datetime ASC";
                                    $res_topic = mysqli_query($connect_db, $sql_topic);

                                    /// get form record //
                                
                                    $sql_sum_score = "SELECT SUM(score) AS score FROM tbl_qc_record WHERE job_qc_id ='{$row_qc_id['job_qc_id']}' ";
                                    $res_sum_score = mysqli_query($connect_db, $sql_sum_score);
                                    $row_sum_score = mysqli_fetch_assoc($res_sum_score);

                                    $total_score += $row_sum_score['score'];

                                    while ($row_topic = mysqli_fetch_assoc($res_topic)) {
                                        $sql_checklist2 = "SELECT * FROM tbl_qc_checklist a
                            WHERE a.topic_qc_id = '{$row_topic['topic_qc_id']}' ORDER BY a.create_datetime ASC";
                                        $res_checklist2 = mysqli_query($connect_db, $sql_checklist2);
                                        $row_checklist2 = mysqli_fetch_assoc($res_checklist2);
                                        ?>
                                        <thead>

                                            <tr>
                                                <?php

                                                ?>
                                                <td colspan="3">
                                                    <?php
                                                    $sql_checklist_sp = "SELECT a.checklist_name,a.checklist_id,a.topic_qc_id, b.score,b.record_id,b.text_score, c.score_name, d.topic_detail,d.topic_qc_id FROM tbl_qc_checklist a 
                     LEFT JOIN tbl_qc_record b ON a.checklist_id = b.checklist_id 
                     LEFT JOIN tbl_qc_score c ON b.score = c.score AND b.checklist_id = c.checklist_id
                     LEFT JOIN tbl_qc_topic d ON d.topic_qc_id = a.topic_qc_id 
                    WHERE b.job_qc_id = '$job' AND d.topic_qc_id = '{$row_topic['topic_qc_id']}' ORDER BY d.topic_detail ASC ";
                                                    $res_checklist_sp = mysqli_query($connect_db, $sql_checklist_sp);
                                                    $row_checklist_sp = mysqli_fetch_assoc($res_checklist_sp);
                                                    ?>
                                                    <?php
                                                    $sql_p = "SELECT COUNT(CASE WHEN a.score = 1 THEN 1 END) AS pass ,COUNT(CASE WHEN a.score = 0 THEN 1 END) AS fail FROM tbl_qc_record a 
                    LEFT JOIN tbl_qc_checklist b ON a.checklist_id = b.checklist_id
                    LEFT JOIN tbl_qc_topic c ON b.topic_qc_id = c.topic_qc_id 
                    WHERE a.job_qc_id = '$job' AND b.topic_qc_id = '{$row_topic['topic_qc_id']}'";
                                                    $res_p = mysqli_query($connect_db, $sql_p);

                                                    while ($row_p = mysqli_fetch_assoc($res_p)) {
                                                        if ($row_p['fail'] == '0') {
                                                            echo $row_checklist_sp['topic_detail'] . ' <label class="badge badge-primary text-size"> ผ่าน</label>';
                                                        } else {
                                                            echo $row_checklist_sp['topic_detail'] . ' <label class="badge badge-danger text-size"> ไม่ผ่าน</label>';
                                                        }
                                                    }
                                                    ?>



                                                </td>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql_checklist = "SELECT a.checklist_name,a.topic_qc_id, b.score,b.record_id,b.text_score, c.score_name, d.topic_detail,d.topic_qc_id FROM tbl_qc_checklist a LEFT JOIN tbl_qc_record b ON a.checklist_id = b.checklist_id LEFT JOIN tbl_qc_score c ON b.score_id = c.score_id AND b.checklist_id = c.checklist_id LEFT JOIN tbl_qc_topic d ON d.topic_qc_id = a.topic_qc_id WHERE b.job_qc_id = '$job' AND d.topic_qc_id = '{$row_topic['topic_qc_id']}' ORDER BY a.create_datetime ASC";
                                            $res_checklist = mysqli_query($connect_db, $sql_checklist)

                                                ?>
                                            <?php
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
                                    <?php }
                                }

                                ?>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            สรุปผล :
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

                                            <?php
                                            if ($row_p_all['fail'] != '0') {
                                                echo '<a href="" type="button" class="btn btn-warning w-100 text-white">ส่งซ่อม</a>';
                                            }

                                            ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
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
        $("#showModal").load("ajax/qc_work_detail/modal_image.php", {
            record_id: record_id
        });
    }
</script>