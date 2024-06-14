
    <div class="col-md-3">
        <label>วันที่</label>

        <div class="input-group date">

            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input class="form-control datepicker" readonly type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
        </div>

    </div>

    <div class="col-md-3">
        <label> ถึงวันที่</label>
        <div class="input-group date">

            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input class="form-control datepicker" readonly type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>">
        </div>

    </div>
