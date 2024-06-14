<?php

session_start();

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

?>
<table class="table table-striped table-bordered table-hover">




    <thead>

        <tr>

            <th style="width:3%;">#</th>

            <th style="width:25%;">ชื่อ</th>

            <th style="width:5%;" class="text-center">สถานะ</th>

            <th style="width:3%;"></th>
          

        </tr>

    </thead>

    <tbody>

        <?php

        $sql = "SELECT *  FROM tbl_warranty_type";

        $rs = mysqli_query($connection, $sql) or die($connection->error);





        $i = 0;

        while ($row = mysqli_fetch_assoc($rs)) {

            $i++;


            ?>

            <tr id="tr_<?php echo $zone_id = $row['warranty_type_id']; ?>">


                <td>
                    <?php echo $i; ?>
                </td>

                <td>
                    <?php echo $row['warranty_type_name']; ?>
                </td>

                <td class="text-center">
                    <button
                        class="btn btn-xs   <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>"
                        onclick="ChangeStatus(this.value,'<?php echo $row['warranty_type_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                </td>


                <td class="text-center">
                    <button class="btn btn-xs btn-warning btn-sm" type="button"
                        onclick="Modal_Edit('<?php echo $row['warranty_type_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
              

            </tr>
        <?php } ?>
    </tbody>
</table>