<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$type_id=$_POST['type_id'];
$list = array();

$sql = "SELECT * FROM tbl_sub_job_type WHERE job_type ='$type_id'";
$result  = mysqli_query($connect_db, $sql);

while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "sub_job_type_id" => $row['sub_job_type_id'],
        "sub_type_name" => $row['sub_type_name'],
        "job_type" => $row['job_type'],
        "active_status" => $row['active_status'],
    );

    array_push($list,$temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:40%;">ชื่องานย่อย</th>
            <th style="width:40%;">ประเภทงาน</th>
            <th style="width:40%;">สถานะ</th>
            <th style="width:40%;"></th>

        </tr>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 0;
        foreach ($list as $row) { 
            ?>
        <tr>
            <td><?php echo ++$i; ?></td>
            <td><?php echo $row['sub_type_name']; ?></td>
            <?php
                if($row['job_type'] == 1){
                    $job_type_text="CM";
                }else if($row['job_type'] == 2){
                    $job_type_text="PM";
                }else if($row['job_type'] == 3)  {
                    $job_type_text="Installation";
                }else if($row['job_type'] == 4){
                    $job_type_text="งานอื่นๆ";
                }

                ?>
            <td><?php echo $job_type_text; ?></td>
            
            <td>
                <button
                    class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger' ; ?>"
                    onclick="ChangeStatus(this,'<?php echo $row['sub_job_type_id']; ?>')">
                    <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน' ; ?>
                </button>
            </td>
            <td>
                <button class="btn btn-xs btn-warning btn-block" type="button"
                    onclick="ModalEdit('<?php echo $row['sub_job_type_id']; ?>')">
                    แก้ไขข้อมูล
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>