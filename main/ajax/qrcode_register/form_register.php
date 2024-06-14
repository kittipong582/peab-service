
<center>
    <div class="mb-3">
        <label for="">QR Code</label>
        <input type="text" class="form-control w-50" id="qr_register" name="qr_register" style="align-items: absolute;">
    </div>
</center>

<div class="row">
    <div class="col-1"></div>
    <div class="col-4">
        <div id="customer_div" hidden>
            <div class="form-group">
                <label>ลูกค้า</label>
                <select class="form-control select2" id="customer" name="customer" data-width="100%" onchange="GetBranch()">
                    <?php while ($row_customer = mysqli_fetch_assoc($res_customer)) { ?>
                        <option value="<?php echo $row_customer['customer_id']; ?>"><?php echo $row_customer['customer_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div id="branch_div" hidden>
            <div class="form-group">
                <label>สาขา</label>
                <select class="form-control select2" id="branch" name="branch" data-width="100%">
                    <option value=""></option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div id="register_btn" hidden>
            <button class="btn btn-primary btn-sm mt-4" onclick="QRRegister()">ลงทะเบียน</button>
        </div>
    </div>
</div>
<script>
    $("#qr_register").on("keydown", function(e) {
        if (e.which == 13) {
            let qr_register = $("#qr_register").val();
            if (qr_register != "") {

                $.ajax({
                    type: "POST",
                    url: "ajax/qrcode_register/check_qr.php",
                    data: {
                        qr_register: qr_register
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.result == 1) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'QR Code มีการใช้งานแล้ว',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 0) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'ไม่พบ QR Code',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 9) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 'ok') {
                            GetBranch()
                            $("#customer_div").attr("hidden", false);
                            $("#branch_div").attr("hidden", false);
                            $("#register_btn").attr("hidden", false);
                        }
                    }
                });


            }
        }

    })

    $(".select2").select2({
        width: "75%"
    });

    function GetBranch() {
        let customer_id = $("#customer").val();

        $.ajax({
            type: "POST",
            url: "ajax/qrcode_register/get_branch.php",
            data: {
                customer_id: customer_id
            },
            dataType: "html",
            success: function(response) {
                $("#branch").html(response);
            }
        });
    }

    function QRRegister() {
        let qr_register = $("#qr_register").val();
        let customer_id = $("#customer").val();
        let branch = $("#branch").val();
        $.ajax({
            type: "POST",
            url: "ajax/qrcode_register/qr_update.php",
            data: {
                qr_register: qr_register,
                customer_id: customer_id,
                branch: branch
            },
            dataType: "json",
            success: function(data) {
                if (data.result == 1) {
                    swal({
                        title: 'ลงทะเบียนเรียบร้อย',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }, function() {
                        swal.close();
                        $("#myModal").modal('hide');
                    });
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: '',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (data.result == 9) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });

    }
</script>