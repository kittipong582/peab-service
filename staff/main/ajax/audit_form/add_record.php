 <?php
    @session_start();
    @include("../../../../config/main_function.php");

    @require '../../vendor/autoload.php';
    @require '../../function.php';

    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $record_id  = mysqli_real_escape_string($connect_db, $_POST['record_id']);
    $job = mysqli_real_escape_string($connect_db, $_POST['job']);
    $checklist_id = mysqli_real_escape_string($connect_db, $_POST['checklist_id']);
    $score = mysqli_real_escape_string($connect_db, $_POST['score']);
    $remark = mysqli_real_escape_string($connect_db, $_POST['remark']);

    // $produce_img = mysqli_real_escape_string($connect_db, $_POST['produce_img']);
    // $produce_img2 = mysqli_real_escape_string($connect_db, $_POST['produce_img2']);

    use Aws\S3\S3Client;
    // Instantiate an Amazon S3 client.
    $s3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'ap-southeast-1',
        'credentials' => [
            'key'    => 'AKIAZ22PRPGFGD6B2RUO',
            'secret' => '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'
        ]
    ]);
    $bucket = 'peabery-upload';

    if ($connect_db) {

        $checklist_check = "SELECT * FROM tbl_audit_record WHERE job_id = '$job' AND checklist_id = '$checklist_id'";
        $res_check = mysqli_query($connect_db, $checklist_check);
        if (mysqli_num_rows($res_check) < 1) {
            $sql_insert = "INSERT INTO tbl_audit_record SET  
            record_id = '$record_id',
            job_id = '$job',
            checklist_id = '$checklist_id',
            score = '$score',
            remark = '$remark'";
        } else {
            $sql_insert = "UPDATE tbl_audit_record SET 
            score = '$score',
            remark = '$remark'
            WHERE record_id = '$record_id'";
        }

        $res_insert = mysqli_query($connect_db, $sql_insert)  or die($connect_db->error);
        if ($res_insert) {

            if (is_array($_FILES['produce_img'])) {
                $list = 1;
                foreach ($_FILES['produce_img']['name'] as $name => $value) {

                    if ($_FILES['produce_img']['name'][$name] == "") {
                        $arr['result'] = 2; /// ไม่มีรูป insert success
                    }

                    $tmpFilePath_1 = $_FILES['produce_img']['tmp_name'][$name];
                    $file_1  = explode(".", $_FILES['produce_img']['name'][$name]);
                    $count1 = count($file_1) - 1;
                    $file_surname_1 = $file_1[$count1];
                    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;
                    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG' || $file_surname_1 == 'PDF' || $file_surname_1 == 'pdf') {
                        if (move_uploaded_file($tmpFilePath_1, "../../upload/audit/" . $filename_images_1)) {

                            // $file_Path = __DIR__ . '../../upload/audit/' . $filename_images_1;
                            $file_Path = '../../upload/audit/' . $filename_images_1;
                            $key = basename($file_Path);

                            $result = $s3Client->putObject([
                                'Bucket' => $bucket,
                                'Key'    => $key,
                                'Body'   => fopen($file_Path, 'r'),
                                'ACL'    => 'public-read', // make file 'public'
                            ]);

                            $urlFile = $result->get('ObjectURL');

                            $sql_chk = "SELECT * FROM tbl_audit_record_img WHERE record_id = '$record_id' AND list_order = '$list'";
                            $res_chk = mysqli_query($connect_db, $sql_chk);
                            $row_chk = mysqli_fetch_assoc($res_chk);
                            $num_chk = mysqli_num_rows($res_chk);
                            if ($num_chk < 1) {
                                $record_img_id  = getRandomID2(10, 'tbl_audit_record_img', 'record_img_id');
                                $sql_img = "INSERT INTO tbl_audit_record_img SET record_img_id = '$record_img_id', record_id = '$record_id',file_part = '$filename_images_1',list_order = '$list'";
                            } else {

                                $row_chk['record_img_id'];
                                $sql_img = "UPDATE tbl_audit_record_img SET  file_part = '$filename_images_1' WHERE record_img_id = '{$row_chk['record_img_id']}'";
                            }

                            $res_img = mysqli_query($connect_db, $sql_img)  or die($connect_db->error);

                            @unlink($file_Path);
                            $arr['result'] = 1; /// มีรูป insert success
                        }
                    }
                    $list++;
                }
            }
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 9;
    }

    echo json_encode($arr);
    ?>