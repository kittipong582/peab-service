<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$branch_id = $_POST['branch_id'];


?>
<style>
    .table-responsive {
        max-width: 300%;
    }

    .table {
        max-width: 500%;
    }
</style>

<div class="form-group">
    <div class="row">

        <div class="col-12 table-responsive" style="width: 180%;">
            <table class=" table-striped table-bordered table-hover table" style="width: 200%;">
                <thead>
                    <tr>
                        <th style="width:5%;"></th>
                        <th style="width:18%;">อะไหล่</th>
                        <th style="width:13%;">คงเหลือ</th>
                        <th style="width:13%;">จำนวน</th>
                        <th style="width:20%;">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody id="Addform_ax" name="Addform_ax">
                    <div id="counter" hidden>0</div>

                </tbody>
            </table>
        </div>

    </div>


    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row('<?php echo $branch_id; ?>');"><i class="fa fa-plus"></i>
                เพิ่มรายการ
            </button>
        </div>
    </div>
</div>

