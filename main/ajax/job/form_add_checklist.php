<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


?>


    <div class="mb-3 col-12">
        <div class="row">
            <div class="col-3">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row_topic();"><i class="fa fa-plus"></i>
                    เพิ่มหัวข้อ
                </button>
            </div>
            <div class="col-9" id="Add_checklist_form" name="Add_checklist_form">
                <div id="topic_counter" hidden>0</div>
            </div>
        </div>
    </div>


<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {


    });

    function desty(i) {
        document.getElementById('tr_' + i).remove();
    }


    function add_row_topic() {

        $('#topic_counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#topic_counter').html();
        var topic_id = $('#topic_id').val() 

        $.ajax({
            url: 'ajax/job/Add_row_checklist.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
                topic_id: topic_id
            },
            success: function(data) {

                $('#Add_checklist_form').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }
</script>