<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

?>


<div class="row">
    <div class="col-12 mb-1 text-right">
        <div class="form-group">
            <button class="btn btn-sm btn-success" onclick="Modal_daily_detail('<?php echo $job_id ?>')">เพิ่ม</button>
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered dataTables-example daily_tbl">
                <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th width="20%" class="text-center">เวลา</th>
                        <th width="50%" class="text-center">รายละเอียดงาน</th>
                        <th width="20%" class="text-center">ผู้บันทึก</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT a.*,.b.fullname FROM tbl_job_daily a
            LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
             WHERE job_id = '$job_id' ORDER BY create_datetime";
                    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($rs)) {
                        $i++;
                    ?>
                        <tr id="tr_<?php echo $row['fixed_id']; ?>">
                            <td><?php echo $i; ?></td>
                            <td class="text-center">
                                <?php echo date("d-m-Y H:i", strtotime($row['create_datetime'])); ?>
                            </td>
                            <td class="text-center">
                                <?php echo $row['daily_detail']; ?>

                            </td>
                            <td class="text-center">
                                <?php echo $row['fullname']; ?>
                            </td>
                            <td class="text-center">
                                <div class="form-group">
                                    <!-- <button class="btn btn-sm btn-warning btn-block" onclick="Modal_Edit_daily('<?php echo $row['daily_id'] ?>')">แก้ไข</button> -->
                                    <button class="btn btn-sm btn-danger btn-block" onclick="Delete_daily('<?php echo $row['daily_id'] ?>')">ลบ</button>

                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>