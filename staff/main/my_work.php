<?php include 'header.php'; ?>
<div class="p-1">
    <div class="my-3">
        <input type="text" class="form-control date text-center" readonly>
    </div>

    <div class="ibox mb-3 d-block border-cm">
        <div class="ibox-title">
            CM650100001 - อเมซอน สาขา รังสิต <br>
            [นัดหมาย]
            <div class="ibox-tools">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#" class="dropdown-item">Config option 1</a>
                    </li>
                    <li><a href="#" class="dropdown-item">Config option 2</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ibox-content">
            <table class="w-100">
                <tr>
                    <td>S/N</td>
                    <td>: xxxxxxxxxxx</td>
                    <td>ประเภท</td>
                    <td>: xxxxxxxxxxx</td>
                </tr>
                <tr>
                    <td>เวลานัดหมาย</td>
                    <td colspan="3">: xxxxxxxxxxx</td>
                </tr>
                <tr>
                    <td>ติดต่อ</td>
                    <td>: xxxxxxxxxxx</td>
                    <td>โทร</td>
                    <td>: xxxxxxxxxxx</td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-phone"></i> Call</button>
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-map-marker"></i> Map</button>
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-edit"></i> Record</button>
                </div>
            </div>
        </div>
    </div>

    <div class="ibox mb-3 d-block border-pm">
        <div class="ibox-title">
            CM650100001 - อเมซอน สาขา รังสิต <br>
            [นัดหมาย]
            <div class="ibox-tools">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#" class="dropdown-item">Config option 1</a>
                    </li>
                    <li><a href="#" class="dropdown-item">Config option 2</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ibox-content">
            <table class="w-100">
                <tr>
                    <td>S/N</td>
                    <td>: xxxxxxxxxxx</td>
                    <td>ประเภท</td>
                    <td>: xxxxxxxxxxx</td>
                </tr>
                <tr>
                    <td>เวลานัดหมาย</td>
                    <td colspan="3">: xxxxxxxxxxx</td>
                </tr>
                <tr>
                    <td>ติดต่อ</td>
                    <td>: xxxxxxxxxxx</td>
                    <td>โทร</td>
                    <td>: xxxxxxxxxxx</td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-phone"></i> Call</button>
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-map-marker"></i> Map</button>
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-edit"></i> Record</button>
                </div>
            </div>
        </div>
    </div>

    <div class="ibox mb-3 d-block border-install">
        <div class="ibox-title">
            CM650100001 - อเมซอน สาขา รังสิต <br>
            [นัดหมาย]
            <div class="ibox-tools">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#" class="dropdown-item">Config option 1</a>
                    </li>
                    <li><a href="#" class="dropdown-item">Config option 2</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ibox-content">
            <table class="w-100">
                <tr>
                    <td>S/N</td>
                    <td>: xxxxxxxxxxx</td>
                    <td>ประเภท</td>
                    <td>: xxxxxxxxxxx</td>
                </tr>
                <tr>
                    <td>เวลานัดหมาย</td>
                    <td colspan="3">: xxxxxxxxxxx</td>
                </tr>
                <tr>
                    <td>ติดต่อ</td>
                    <td>: xxxxxxxxxxx</td>
                    <td>โทร</td>
                    <td>: xxxxxxxxxxx</td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-phone"></i> Call</button>
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-map-marker"></i> Map</button>
                    <button class="btn btn-white btn-sm" type="button"><i class="fa fa-edit"></i> Record</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
<script>
    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",
        
    }).datepicker("setDate",'now');

</script>