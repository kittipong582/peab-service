<?php
include('header2.php');
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$transfer_id = $_POST['transfer_id'];

$sql = "SELECT a.*,b.fullname AS create_name FROM tbl_transfer a
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
WHERE a.transfer_id = '$transfer_id';";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;
$row = mysqli_fetch_array($result);

switch ($row['approve_result']) {
    case "1":
    $chk = "<span class = 'badge rounded-pill bg-success text-black'> รับ </span>";
      break;
    case "0":
    $chk = "<span class = 'badge rounded-pill bg-danger text-black'> ไม่รับ </span>";
      break;
    default:
    $chk = "<span class = 'badge rounded-pill bg-warning text-black'> รอดำเนินการ </span>";
  }
  
?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">ยืนยันการรับของ <?php echo $chk ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>

<form id="frm_confirm" method="POST" enctype="multipart/form-data" novalidate>
    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" name="transfer_id" id="transfer_id" value="<?php echo $transfer_id ?>">


        <div class="row" style="margin-bottom:10px;">

            <!-- <div class="col-md-12 col-xs-12"> -->

                <?php 
            
            if($row['receive_result'] != NULL || $row['receive_result'] != ""){

                $sql_d = "SELECT * FROM tbl_transfer_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                WHERE a.transfer_id = '{$row['transfer_id']}' ;";
                // echo $sql_d;
                $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);

                $remark = "-";
                if($row['receive_remark'] != ""){
                    $remark = $row['receive_remark'];
                }

                $ax_withdraw_date = "";
                    if($row['ax_withdraw_date'] == '1970-01-01'){
                        $ax_withdraw_date = 'ไม่ระบุ';
                    }else{
                        $ax_withdraw_date = date('d-m-Y',strtotime($row['ax_withdraw_date']));
                    }

                    $note = "";
                    if($row['note'] == ""){
                        $note = '-';
                    }else{
                        $note = $row['note'];
                    }

                    $sql_u = "SELECT branch_name FROM tbl_branch WHERE branch_id = '{$row['from_branch_id']}' ;";
                    $rs_u  = mysqli_query($connect_db, $sql_u) or die($connection->error);
                    $row_u = mysqli_fetch_array($rs_u);
            ?>
                <div class="row">

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเลขการโอนย้าย</b></label><br>
                            <label><?php echo $row['transfer_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>AX_Ref_no</b></label><br>
                            <label><?php echo $row['ax_ref_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่เบิกจาก AX</b></label><br>
                            <label><?php echo $ax_withdraw_date ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>ผู้ทำรายการ</b></label><br>
                            <label><?php echo $row['create_name'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label><b>ผู้โอน</b></label><br>
                            <label><?php echo $row_u['branch_name'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่ทำรายการ</b></label><br>
                            <label><?php echo date('d-m-Y',strtotime($row['create_datetime'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเหตุ</b></label><br>
                            <label><?php echo $note; ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเหตุการอนุมัติ</b></label><br>
                            <label><?php echo $remark ?></label>
                        </div>
                    </div>

                    <div class="col-12">

                        <table
                            class="table table-striped table-bordered table-hover dataTables-example transfer_spare_part_tbl">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">รหัสอะไหล่ </th>
                                    <th class="text-left" style="width:35%;">สิ่งที่โอนย้าย</th>
                                    <th class="text-center" style="width:15%;">จำนวน</th>
                                    <!-- <th class="text-center" style="width:5%;">หมายเหตุ</th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 0;

                                while ($row_d = mysqli_fetch_array($rs_d)) {

                                    $i++;


                                ?>


                                <tr>

                                    <td class="text-center"><?php echo $row_d['spare_part_code']; ?></td>
                                    <td class="text-left"><?php echo $row_d['spare_part_name']; ?></td>
                                    <td class="text-center"><?php echo $row_d['quantity']; ?></td>


                                </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php 
                }else{

                    $sql_d = "SELECT * FROM tbl_transfer_detail a JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                WHERE a.transfer_id = '{$row['transfer_id']}' ;";
                // echo $sql_d;
                $rs_d  = mysqli_query($connect_db, $sql_d) or die($connection->error);

                    $ax_withdraw_date = "";
                    if($row['ax_withdraw_date'] == '1970-01-01'){
                        $ax_withdraw_date = 'ไม่ระบุ';
                    }else{
                        $ax_withdraw_date = date('d-m-Y',strtotime($row['ax_withdraw_date']));
                    }

                    $note = "";
                    if($row['note'] == ""){
                        $note = '-';
                    }else{
                        $note = $row['note'];
                    }

                    $sql_u = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['from_user_id']}' ;";
                    $rs_u  = mysqli_query($connect_db, $sql_u) or die($connection->error);
                    $row_u = mysqli_fetch_array($rs_u);
                ?>

                <div class="row">

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเลขการโอนย้าย</b></label><br>
                            <label><?php echo $row['transfer_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>AX_Ref_no</b></label><br>
                            <label><?php echo $row['ax_ref_no'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่เบิกจาก AX</b></label><br>
                            <label><?php echo $ax_withdraw_date ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>ผู้ทำรายการ</b></label><br>
                            <label><?php echo $row['create_name'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label><b>ผู้โอน</b></label><br>
                            <label><?php echo $row_u['fullname'] ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>วันที่ทำรายการ</b></label><br>
                            <label><?php echo date('d-m-Y',strtotime($row['create_datetime'])); ?></label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            <label><b>หมายเหตุ</b></label><br>
                            <label><?php echo $note; ?></label>
                        </div>
                    </div>

                    <div class="col-12">
                        <table
                            class="table table-striped table-bordered table-hover dataTables-example transfer_spare_part_tbl">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:8%;">รหัสอะไหล่ </th>
                                    <th class="text-left" style="width:35%;">สิ่งที่โอนย้าย</th>
                                    <th class="text-center" style="width:15%;">จำนวน</th>
                                    <!-- <th class="text-center" style="width:5%;">หมายเหตุ</th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 0;

                                while ($row_d = mysqli_fetch_array($rs_d)) {

                                    $i++;


                                ?>


                                <tr>

                                    <td class="text-center"><?php echo $row_d['spare_part_code']; ?></td>
                                    <td class="text-left"><?php echo $row_d['spare_part_name']; ?></td>
                                    <td class="text-center"><?php echo $row_d['quantity']; ?></td>


                                </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <br>


                    <!-- <div class="col-12">
                        <div class="form-group ">
                            <label>หมายเหตุ</label><br>
                            <label><?php echo $row ?></label>
                        </div>
                    </div> -->
                </div>



                <?php 
                }
                ?>


            <!-- </div> -->


        </div>

        <div class="row">
            <!-- <div class="col-12" style="text-align:right;">
                <button class="btn btn-success btn-md" type="button"
                    onclick="submit_approve();">ยืนยันการอนุมัติ</button>
            </div> -->
            <div class="col-12" style="text-align:right;">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
            </div>
        </div><br>

    </div>
</form>



<script>
$(document).ready(function() {

    $(".datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $(".select2").select2({});


});

$('.summernote').summernote({
    toolbar: false,
});

$('.transfer_spare_part_tbl').DataTable({
    pageLength: 25,
    responsive: true,
});


</script>