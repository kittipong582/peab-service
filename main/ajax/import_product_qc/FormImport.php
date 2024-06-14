<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle"><strong>นำเข้าสินค้า</strong></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form_import" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <label class="text-danger"><strong>Only (.xlsx, .xls) </strong> <span
                        class="text-danger">*</span></label>
                <div class="custom-file mb-2">
                    <input type="file" class="custom-file-input" name="file_upload" id="file_upload"
                        onchange="readURLxlsx(this,value,'#blah');"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <label id="blah" for="file_upload" class="custom-file-label">Select file...</label>
                </div>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="ImportFile();">Confirm</button>
    </div>