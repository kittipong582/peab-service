<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$type_id = $_GET["type_id"];



$no = 1;

$sql = "SELECT * FROM tbl_product_type_qc_checklist";
$res = mysqli_query($connect_db, $sql);


//echo"$sql";
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th>หัวข้อ</th>
            <th>Checkbox,Dropdown</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td>
                    <?php echo $no; ?>
                </td>

                <td>
                    <?php echo $row['checklist_name']; ?>
                </td>

                <td>
                    <?php echo ($row['checklist_type'] == 1) ? 'Checkbox' : 'Dropdown'; ?>
                </td>

                <td>
                    <button class="btn btn-xs btn-warning btn-block" type="button"
                        onclick="ModalList('<?php echo $row['checklist_id']; ?>')">
                        จัดการ
                    </button>
                </td>

            </tr>
            <?php $no++; ?>
        <?php } ?>
    </tbody>
</table>