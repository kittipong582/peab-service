<?php
session_start();
include ("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

/// get form record //
$user = mysqli_real_escape_string($connection, $_POST['user']);
$branch = mysqli_real_escape_string($connection, $_POST['branch']);
$page = mysqli_real_escape_string($connection, $_POST['page']);
$product_type_id = mysqli_real_escape_string($connection, $_POST['product_type']);
$job = mysqli_real_escape_string($connection, $_POST['job']);

$sql_topic = "SELECT * FROM tbl_job_qc WHERE product_type_id = '$product_type_id'";
$res_topic = mysqli_query($connection, $sql_topic);
$row_topic = mysqli_fetch_assoc($res_topic);


$sql = "SELECT * FROM tbl_qc_form a
LEFT JOIN tbl_qc_topic b
ON a.qc_id = b.qc_id
LEFT JOIN tbl_qc_checklist c
ON b.topic_qc_id = c.topic_qc_id
WHERE a.product_type_id = '{$row_topic['product_type_id']}' AND a.active_status = '1' AND c.list_order = '$page' ORDER BY b.create_datetime ASC";

$res = mysqli_query($connection, $sql);

$sql_count = "SELECT COUNT(*) AS count_list FROM tbl_qc_form a
LEFT JOIN tbl_qc_topic b
ON a.qc_id = b.qc_id
LEFT JOIN tbl_qc_checklist c
ON b.topic_qc_id = c.topic_qc_id
WHERE a.product_type_id = '{$row_topic['product_type_id']}' AND a.active_status = '1' ORDER BY b.create_datetime ASC";
$res_count = mysqli_query($connection, $sql_count);
$count = mysqli_fetch_assoc($res_count);
$next_page = $page + 1;
/// get form record //

// $sql_choice = "SELECT * FROM tbl_qc_checklist WHERE ";
// $res_choice = mysqli_query($connection, $sql_choice);
// $row_choice = mysqli_fetch_assoc($res_choice);

?>
<div class="mb-3">
    <label for="">ลำดับหัวข้อ</label>
    <select class="select2 w-100" id="page" name="page" onchange="GetForm(this.value)">
        <?php for ($i = 1; $i <= $count['count_list']; $i++) { ?>
            <option value="<?php echo $i; ?>" <?php echo ($page == $i) ? "selected" : "" ?>>
                <?php echo $i; ?>
            </option>
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
            $sql_record = "SELECT * FROM tbl_qc_record WHERE job_qc_id = '$job' AND checklist_id = '{$row['checklist_id']}'";
            $res_record = mysqli_query($connection, $sql_record);
            $row_record = mysqli_fetch_assoc($res_record);
            if ($row_record['record_id'] != "") {
                $record_id = $row_record['record_id'];
            } else {
                $record_id = getRandomID2(10, 'tbl_qc_record', 'record_id');
            }
            /// get record ///
        
            ?>
            <input type="hidden" id="job" name="job" value="<?php echo $job; ?>">
            <input type="hidden" id="record_id" name="record_id" value="<?php echo $record_id; ?>">
            <input type="hidden" id="checklist_id" name="checklist_id" value="<?php echo $row['checklist_id'] ?>">
            <input type="hidden" id="checklist_type" name="checklist_type" value="<?php echo $row['checklist_type'] ?>">
            <h1>
                <?php echo $row['checklist_name']; ?>
            </h1>
            <?php
            $sql_list = "SELECT * FROM tbl_qc_checklist WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
            $res_list = mysqli_query($connection, $sql_list);
            while ($row_list = mysqli_fetch_assoc($res_list)) {

                ?>

                <?php
                $sql_score_text = "SELECT * FROM tbl_qc_score WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
                $res_score_text = mysqli_query($connection, $sql_score_text);
                $row_score_text = mysqli_fetch_assoc($res_score_text);
                ?>
                <div class="form-check">
                    <?php if ($row_list['checklist_type'] == '1') { ?>
                        <label for="">ช่องกรอกข้อมูล</label>
                        <?php
                        $sql_input = "SELECT * FROM tbl_qc_record WHERE job_qc_id = '$job'AND checklist_id = '{$row['checklist_id']}'";
                        $res_input = mysqli_query($connection, $sql_input);
                        $row_input = mysqli_fetch_assoc($res_input);
                        ?>
                        <?php if ($row_input['text_score'] == ""): ?>
                            <input type="text" id="text_score" name="text_score" class="form-control" value="">
                        <?php else: ?>
                            <input type="text" id="text_score" name="text_score" class="form-control"
                                value="<?php echo $row_input['text_score']; ?>">
                        <?php endif; ?>



                    <?php } else if ($row_list['checklist_type'] == '2') { ?>
                            <label for="">ตัวเลือก</label>
                            <select class="form-control select2" id="" name="" data-width="100%">
                                <option value="x">กรุณาเลือก</option>
                                <?php
                                $sql_choice = "SELECT * FROM tbl_qc_checklist WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
                                $result_choice = mysqli_query($connection, $sql_choice);
                                while ($row_choice = mysqli_fetch_assoc($result_choice)) {
                                    ?>
                                    <option value="<?php echo $row_choice['choicelist_id'] ?>">
                                    <?php echo $row_choice['choice_detail']; ?>
                                    </option>
                            <?php } ?>
                            </select>
                    <?php } else if ($row_list['checklist_type'] == '3') { ?>
                                <label for="">เลือก</label>
                            <?php
                             $sql_score = "SELECT * FROM tbl_qc_score WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
                            $res_score = mysqli_query($connection, $sql_score);
                            ?>
                        <?php while ($row_score = mysqli_fetch_assoc($res_score)) { ?>
                                <?php
                                $sql_checkid = "SELECT * FROM tbl_qc_record WHERE score_id = '{$row_score['score_id']}'";
                                $res_checkid = mysqli_query($connection, $sql_checkid);
                                $row_checkid = mysqli_fetch_assoc($res_checkid);
                                ?>
                                    <div class="form-check">
                                        <input class="form-check-input" hidden type="radio" id="score_id<?php echo $row_score['score_name']; ?>"
                                            name="score_id" value="<?php echo $row_score['score_id']; ?>" <?php echo ($row_record['score_id'] == $row_score['score_id']) ? "checked" : "" ?>>

                                        <input class="form-check-input" id="score<?php echo $row_score['score_name']; ?>" name="score"
                                            type="radio" value="<?php echo $row_score['score']; ?>" onclick="selectLowerRadio(this)" <?php echo ($row_record['score_id'] == $row_score['score_id']) ? "checked" : "" ?>
                                            style="border-radius: 50%; width: 20px; height: 20px; margin-top: 10px;">

                                        <label class="form-check-label ml-3" for="score<?php echo $row_score['score_name']; ?>">
                                            <span style="font-size: 20pt;">
                                        <?php echo $row_score['score_name']; ?>
                                                <!-- <?php echo $row_score['score']; ?> -->
                                            </span>
                                        </label>


                                    </div>

                        <?php } ?>
                    <?php } ?>
                </div>
                <?php
                $sql_detail = "SELECT * FROM tbl_qc_record WHERE record_id = '{$row_record['record_id']}'";
                $res_detail = mysqli_query($connection, $sql_detail) or die($connection->error);
                $row_detail = mysqli_fetch_assoc($res_detail);
                ?>
                <div>
                    <label>หมายเหตุ</label>
                    <textarea name="detail_checklist" id="detail_checklist" rows="4" cols="43" class="form-control"
                        value=""><?php echo $row_detail['detail_checklist'] ?></textarea>
                </div>
            <? } ?>
            <?php
        } ?>

    </section>

    <section class="mb-3">

        <label for=""><span style="font-size: 15pt;">รูปภาพประกอบ</span></label>
        <button type="button" class="btn btn-primary" onclick="addImages()">Add Images</button><br>
        <div class="row mt-3" id="image_row">
            <?php
            $sql_record_img = "SELECT * FROM tbl_qc_record_img WHERE record_id = '{$row_record['record_id']}' ORDER BY list_order ASC ";
            $res_record_img = mysqli_query($connection, $sql_record_img);
            $image_count = 0;


            while ($row_record_img = mysqli_fetch_assoc($res_record_img)) {
                $image_count++;
                ?>
                <div class="col-6">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="BroweForFile">
                                <div id="show_image<?php echo $row_record_img['list_order']; ?>">
                                    <label for="produce_img<?php echo $row_record_img['list_order']; ?>">
                                        <a><img id="blah<?php echo $row_record_img['list_order']; ?>"
                                                src="<?php echo ($row_record_img['file_part'] != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $row_record_img['file_part'] : 'upload/No-Image.png' ?>"
                                                width=" 100%" /></a>
                                    </label>
                                </div><br />
                                <input type="file" name="produce_img[]"
                                    id="produce_img<?php echo $row_record_img['list_order']; ?>" hidden
                                    onchange="ImageReadURL(this, this.value, '#blah<?php echo $row_record_img['list_order']; ?>')"
                                    accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }


            for ($i = $image_count; $i < 2; $i++) {
                ?>
                <div class="col-6">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="BroweForFile">
                                <div id="show_image_<?php echo $i; ?>">
                                    <label for="produce_img_<?php echo $i; ?>">
                                        <a><img id="blah_<?php echo $i; ?>" src="../main/upload/No-Image.png"
                                                width="100%" /></a>
                                    </label>
                                </div><br />
                                <input type="file" name="produce_img[]" id="produce_img_<?php echo $i; ?>" hidden
                                    onchange="ImageReadURL(this, this.value, '#blah_<?php echo $i; ?>')" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

    </section>
</form>
<div class="row">
    <div class="col text-left">
        <?php if ($page != 1) { ?>
            <button class="btn btn-success btn-lg w-100" onclick="GetForm('<?php echo $page - 1 ?>')">ย้อนกลับ</button>
        <?php } ?>
    </div>
    <div class="col text-right">

        <?php if ($next_page > $count['count_list']) { ?>
            <button class="btn btn-primary btn-lg w-100"
                onclick="SubmitChecklist('<?php echo $next_page ?>')">สรุปผล</button>
        <?php } else { ?>
            <button class="btn btn-success btn-lg w-100" onclick="SubmitRecord('<?php echo $next_page ?>')">ถัดไป</button>
        <?php } ?>
    </div>
</div>

<script>
    var imageCount = <?php echo $image_count; ?>;
    imageCount++;
    function addImages() {
        const newRow = document.createElement('div');
        newRow.className = 'col-6';
        newRow.innerHTML = `
        <div class="form-group">
            <div class="form-group">
                <div class="BroweForFile">
                    <div id="show_image${imageCount}">
                        <label for="produce_img${imageCount}">
                            <a><img id="blah${imageCount}" src="../main/upload/No-Image.png" width="100%" /></a>
                        </label>
                    </div><br />
                    <input type="file" name="produce_img[]" id="produce_img${imageCount}" hidden onchange="ImageReadURL(this, this.value, '#blah${imageCount}')" accept="image/*">
                </div>
            </div>
        </div>`;
        document.getElementById('image_row').appendChild(newRow);
        imageCount++;
    }

    function ImageReadURL(input, value, show_position) {
        let fty = ["jpg", "jpeg", "png"];
        let permiss = 0;
        let file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (fty.includes(file_type)) {
            let reader = new FileReader();
            reader.onload = function (e) {
                if (e.target && e.target.result) {
                    document.querySelector(show_position).setAttribute('src', e.target.result);
                } else {
                    console.error('Error reading file.');
                }
            }
            reader.readAsDataURL(input.files[0]);
        } else if (value == "") {
            document.querySelector(show_position).setAttribute('src', 'upload/no-img.png');
            input.value = "";
        } else {
            swal({
                title: "เกิดข้อผิดพลาด!",
                text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
                type: "warning"
            });
            document.querySelector(show_position).setAttribute('src', 'upload/no-img.png');
            input.value = "";
        }
    }
    function selectLowerRadio(upperRadio) {
        var lowerRadioId = "score_id" + upperRadio.id.substring(5);
        document.getElementById(lowerRadioId).checked = true;
    }
</script>