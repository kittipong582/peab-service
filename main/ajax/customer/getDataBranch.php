<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

$customer_id = $_POST['customer_id'];

$sql = "SELECT * FROM tbl_customer_branch WHERE customer_id = '$customer_id'  ";

$result = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    switch ($row['customer_type']) {
        case '1':
            $customer_type = "นิติบุคคล";
            break;
        case '2':
            $customer_type = "บุคคลธรรมดา";
            break;
    }

    $temp_array = array(
        "customer_branch_id" => $row['customer_branch_id'],
        "branch_name" => $row['branch_name'],
        "branch_code" => $row['branch_code'],
        "active_status" => $row['active_status'],

    );

    array_push($list, $temp_array);

}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center">รหัสสาขา</th>
            <th class="text-center">ชื่อสาขา</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
            ?>
            <tr>
                <td>
                    <?php echo ++$i; ?>
                </td>
                <td>
                    <?php echo $row['branch_code']; ?>
                </td>
                <td>
                    <?php echo $row['branch_name']; ?>
                </td>
                <td>
                    <button
                        class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-primary' : 'btn-danger'; ?>"
                        onclick="ChangeStatus(this,'<?php echo $row['customer_branch_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                    <a href="branch_view_detail.php?id=<?php echo $row['customer_branch_id']; ?>"
                        class="btn btn-xs btn-info btn-block">รายละเอียด</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function ChangeStatus(button, customer_branch_id) {
        $.ajax({
            type: "post",
            url: "ajax/customer_branch/ChangeStatus.php",
            data: {

                customer_branch_id: customer_branch_id,

            },
            dataType: "json",
            success: function (response) {

                if (response.result == 1) {

                    if (response.status == 1) {
                        $(button).addClass('btn-primary').removeClass('btn-danger').html('กำลังใช้งาน');
                    } else if (response.status == 0) {
                        $(button).addClass('btn-danger').removeClass('btn-primary').html('ยกเลิกใช้งาน');
                    }

                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

                setTimeout(() => {
                    getDataBranch();
                }, "5000");


            }
        });
    }
</script>