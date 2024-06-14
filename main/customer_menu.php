<div class="ibox">
    <div class="ibox-content">
        <a href="customer_view_detail.php?id=<?php echo $row_detail['customer_id']; ?>" class="btn btn-block btn-sm <?php echo ($pagename == 'customer_view_detail.php') ? 'btn-primary' : 'btn-success'; ?>">ข้อมูลลูกค้า</a>
        <a href="customer_branch.php?id=<?php echo $row_detail['customer_id']; ?>" class="btn btn-block btn-sm <?php echo ($pagename == 'customer_branch.php') ? 'btn-primary' : 'btn-success'; ?>">ข้อมูลสาขา</a>
        <a href="customer_contract_list.php?id=<?php echo $row_detail['customer_id']; ?>" class="btn btn-block btn-sm <?php echo ($pagename == 'customer_contract_list.php') ? 'btn-primary' : 'btn-success'; ?>">สัญญาบริการ</a>
        <a href="customer_payment_edit.php?id=<?php echo $row_detail['customer_id']; ?>" class="btn btn-block btn-sm <?php echo ($pagename == 'customer_payment_edit.php') ? 'btn-primary' : 'btn-warning'; ?>">ตั้งค่าการชำระเงิน</a>
        <a href="customer_form_edit.php?id=<?php echo $row_detail['customer_id']; ?>" class="btn btn-block btn-sm <?php echo ($pagename == 'customer_form_edit.php') ? 'btn-primary' : 'btn-warning'; ?>">แก้ไขลูกค้า</a>
    </div>
</div>