<?php

session_start();

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

?>

<div class="table-responsive">

    <table class="table table-striped dataTables-example">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="20%">รหัสทีม</th>

                <th width="20%">ชื่อทีม</th>

                <th width="18%">ที่อยู่1</th>

                <th width="18%">ที่อยู่2</th>
                <th width="18%">เขต</th>

                <th width="8%">สถานะ</th>

                <th width="7%"></th>

            </tr>

        </thead>

        <tbody>

            <?php
            $branch_id = $_POST['branch_id'];
            $sql = "SELECT *,a.active_status as astatus FROM tbl_branch a 
            LEFT JOIN tbl_zone b on a.zone_id = b.zone_id
                ";

            $rs = mysqli_query($connection, $sql) or die($connection->error);

            $i = 0;

            // echo $sql;
            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;
            ?>

                <tr id="tr_<?php echo $branch_id = $row['branch_id']; ?>">


                    <td><?php echo $i; ?></td>

                    <td>
                        <?php echo $row['team_number']; ?>
                    </td>

                    <td>
                        <?php echo $row['branch_name']; ?>
                    </td>

                    <td>
                        <?php echo $row['address']; ?>
                    </td>

                    <td>

                        <?php
                        echo $row['address2'];
                        ?>
                    </td>

                    <td>

                        <?php
                        echo $row['zone_name'];
                        ?>
                    </td>


                    <td class="text-center">

                        <?php



                        if ($row['astatus'] == 1) {
                        ?>

                            <button class="btn btn-sm btn-primary" onclick="Changestatus('<?php echo $branch_id; ?>');">ใช้งาน</button>

                        <?php
                        } else if ($row['astatus'] == 0) {
                        ?>

                            <button class="btn btn-sm btn-danger" onclick="Changestatus('<?php echo $branch_id; ?>');">ไม่ใช้งาน</button>

                        <?php
                        } ?>


                    </td>

                    <!-- <td>
                    <button
                        class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>"
                        onclick="ChangeStatus(this,'<?php echo $row['barnch_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                </td> -->


                    <td class="text-center">
                        <button class="btn btn-sm btn-warning" onclick="modal_edit('<?php echo $branch_id; ?>');">แก้ไข</button>


                    </td>


                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
    function modal_edit(branch_id) {

        $.ajax({
            type: "post",
            url: "ajax/branch/modal_edit.php",
            data: {
                branch_id: branch_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });
            }
        });

    }





    function Changestatus(branch_id)

    {

        $.ajax({

            type: 'POST',

            url: 'ajax/ChangeStatus.php',

            data: {

                table_name: "tbl_branch",

                key_name: "branch_id",

                key_value: branch_id

            },

            dataType: 'json',

            success: function(data) {

                load_table();

            }

        });

    }
</script>