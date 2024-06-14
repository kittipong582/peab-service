<?php
include ("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$i = $_POST['rowCount'];

?>
<div class="row" id="row_img_<?php echo $i ?>">
    <div class="col-6">
        <div class="form-group">
            <div class="form-group">
                <div class="BroweForFile">
                    <div id="show_image"><label for="produce_img">
                            <!-- <a><img id="blah1" src="upload/no-img.png" width="100%" /></a></label> -->
                            <a><img id="blah[]"
                                    src="<?php echo ($row_record_img['file_part'] != '') ? '../main/upload/qc_img/' . $row_record_img['file_part'] : '../main/upload/No-Image.png/' ?>"
                                    width="100%" /></a></label>
                    </div><br />
                    <input type="file" name="produce_img[]" id="produce_img" hidden
                        onchange="ImageReadURL(this, value, '#blah')" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <div class="form-group">
                <div class="BroweForFile">
                    <div id="show_image"><label for="produce_img">
                            <!-- <a><img id="blah1" src="upload/no-img.png" width="100%" /></a></label> -->
                            <a><img id="blah[]"
                                    src="<?php echo ($row_record_img['file_part'] != '') ? '../main/upload/qc_img/' . $row_record_img['file_part'] : '../main/upload/No-Image.png/' ?>"
                                    width="100%" /></a></label>
                    </div><br />
                    <input type="file" name="produce_img[]" id="produce_img" hidden
                        onchange="ImageReadURL(this, value, '#blah')" accept="image/*">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

    });

    function desty_staff(i) {
        document.getElementById('row_staff_' + i).remove();

    }
</script>