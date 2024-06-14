<?php
session_start();
@include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

/// get form record //
$user = mysqli_real_escape_string($connect_db, $_POST['user']);
$branch = mysqli_real_escape_string($connect_db, $_POST['branch']);
$page = mysqli_real_escape_string($connect_db, $_POST['page']);
$job = mysqli_real_escape_string($connect_db, $_POST['job']);

$sql_topic = "SELECT * FROM tbl_job_audit WHERE job_id = '$job'";
$res_topic = mysqli_query($connect_db, $sql_topic);
$row_topic = mysqli_fetch_assoc($res_topic);

// $sql = "SELECT * FROM tbl_audit_checklist WHERE list_order = '$page' AND active_status ='1'";
$sql = "SELECT * FROM tbl_audit_topic topic 
JOIN tbl_audit_checklist chlist ON topic.topic_id = chlist.topic_id 
WHERE topic.audit_id = '{$row_topic['audit_id']}' AND topic.active_status ='1' AND chlist.list_order = '$page'";

$res = mysqli_query($connect_db, $sql);

$sql_count = "SELECT COUNT(*) AS count_list FROM tbl_audit_topic topic
JOIN tbl_audit_checklist chlist ON topic.topic_id = chlist.topic_id
WHERE topic.audit_id = '{$row_topic['audit_id']}' AND topic.active_status ='1';";
$res_count = mysqli_query($connect_db, $sql_count);
$count = mysqli_fetch_assoc($res_count);
$next_page = $page + 1;
/// get form record //

?>
<div class="mb-3">
    <label for="">ลำดับหัวข้อ</label>
    <select class="select2 w-100" id="page" name="page" onchange="GetForm(this.value)">
        <?php for ($i = 1; $i <= $count['count_list']; $i++) { ?>
            <option value="<?php echo $i; ?>" <?php echo ($page == $i) ? "selected" : "" ?>><?php echo $i; ?></option>
        <?php
            if ($i > 200) {
                exit;
            }
        }
        ?>
    </select>
</div>
<form id="frm_audit" enctype="multipart/form-data">
    <section class="mb-3">
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            $row['checklist_id'];
            /// get record ///
            $sql_record = "SELECT * FROM tbl_audit_record WHERE job_id = '$job' AND checklist_id = '{$row['checklist_id']}'";
            $res_record = mysqli_query($connect_db, $sql_record);
            $row_record = mysqli_fetch_assoc($res_record);
            if ($row_record['record_id'] != "") {
                $record_id = $row_record['record_id'];
            } else {
                $record_id = getRandomID2(10, 'tbl_audit_record', 'record_id');
            }
            /// get record ///

        ?>
            <input type="hidden" id="record_id" name="record_id" value="<?php echo $record_id; ?>">
            <input type="hidden" id="checklist_id" name="checklist_id" value="<?php echo $row['checklist_id'] ?>">
            <h1><?php echo $row['checklist_name']; ?></h1>
            <?php
            $sql_list = "SELECT * FROM tbl_audit_score WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
            $res_list = mysqli_query($connect_db, $sql_list);
            while ($row_list = mysqli_fetch_assoc($res_list)) {
            ?>
                <div class="form-check">
                    <input class="form-check-input" id="score<?php echo $row_list['score_name']; ?>" name="score" type="radio" value="<?php echo $row_list['score']; ?>" <?php echo ($row_record['score'] == $row_list['score']) ? "checked" : "" ?> style="border-radius: 50%; width: 20px; height: 20px; margin-top: 10px;">
                    <label class="form-check-label ml-3" for="score<?php echo $row_list['score_name']; ?>">
                        <span style="font-size: 20pt;"><?php echo $row_list['score_name']; ?> <?php echo $row_list['score']; ?></span>
                    </label>
                </div>
            <? } ?>
        <?php
        } ?>
    </section>
    <section class="mb-3">
        <label for=""><span style="font-size: 15pt;">รูปภาพประกอบ</span></label>
        <div class="row">
            <?php for ($i = 1; $i <= 2; $i++) {
                $sql_record_img = "SELECT * FROM tbl_audit_record_img WHERE record_id = '{$row_record['record_id']}' AND list_order ='$i'";
                $res_record_img = mysqli_query($connect_db, $sql_record_img);
                $row_record_img = mysqli_fetch_assoc($res_record_img);
            ?>
                <div class="col-6">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="BroweForFile">
                                <div id="show_image<?php echo $i; ?>"><label for="produce_img<?php echo $i; ?>">

                                        <!-- <a><img id="blah1" src="upload/no-img.png" width="100%" /></a></label> -->
                                        <a><img id="blah<?php echo $i; ?>" src="<?php echo ($row_record_img['file_part'] != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $row_record_img['file_part'] : 'upload/no-img.png' ?>" width="100%" /></a></label>
                                </div><br />
                                <input type="file" name="produce_img[]" id="produce_img<?php echo $i; ?>" hidden onchange="ImageReadURL(this, value, '#blah<?php echo $i; ?>')" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                if ($i > 10) {
                    exit;
                }
            }
            ?>
            <!-- <div class="col-6">
                <div class="form-group">
                    <div class="form-group">
                        <div class="BroweForFile">
                            <div id="show_image1"><label for="produce_img1">
                                    <a><img id="blah1" src="upload/no-img.png" width="100%" /></a></label>
                            </div><br />
                            <input type="file" name="produce_img[]" id="produce_img1" hidden onchange="ImageReadURL(this, value, '#blah1')" accept="image/*">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="BroweForFile">
                        <div id="show_image2"><label for="produce_img2">
                                <a><img id="blah2" src="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_img['img_id'] ?>" width="100%" /></a></label>
                        </div><br />
                        <input type="file" name="produce_img[]" id="produce_img2" hidden onchange="ImageReadURL(this, value, '#blah2')" accept="image/*">
                    </div>
                </div>
            </div> -->
        </div>
    </section>
</form>
<div class="row">
    <div class="col text-left">
        <?php if ($page !=  1) { ?>
            <button class="btn btn-success btn-lg w-100" onclick="GetForm('<?php echo $page - 1 ?>')">ย้อนกลับ</button>
        <?php } ?>
    </div>
    <div class="col text-right">

        <?php if ($next_page > $count['count_list']) { ?>
            <button class="btn btn-primary btn-lg w-100" onclick="SubmitChecklist('<?php echo $next_page ?>')">สรุปผล</button>
        <?php } else { ?>
            <button class="btn btn-success btn-lg w-100" onclick="SubmitRecord('<?php echo $next_page ?>')">ถัดไป</button>
        <?php } ?>
    </div>
</div>

<script>
    function ImageReadURL(input, value, show_position) {
        let fty = ["jpg", "jpeg", "png"];
        let permiss = 0;
        let file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (jQuery.inArray(file_type, fty) !== -1) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $(show_position).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else if (value == "") {
            $(show_position).attr('src', 'upload/no-img.png');
            $(input).val("");
        } else {
            swal({
                title: "เกิดข้อผิดพลาด!",
                text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
                type: "warning"
            });
            $(show_position).attr('src', 'upload/no-img.png');
            $(input).val("");
            return false;
        }
    }
</script>