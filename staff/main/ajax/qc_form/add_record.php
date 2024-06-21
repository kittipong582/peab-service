<?php
session_start();
// @include ("../../../../config/main_function.php");
include ("../../../../config/main_function.php");
require '../../vendor/autoload.php';
require '../../function.php';

$connection = connectDB("LM=VjfQ{6rsm&/h`");

$record_id = mysqli_real_escape_string($connection, $_POST['record_id']);
$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
$job = mysqli_real_escape_string($connection, $_POST['job']);



use Aws\S3\S3Client;

// Instantiate an Amazon S3 client.
$s3Client = new S3Client([
    'version' => 'latest',
    'region' => 'ap-southeast-1',
    'credentials' => [
        'key' => 'AKIAZ22PRPGFGD6B2RUO',
        'secret' => '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'
    ]
]);
$bucket = 'peabery-upload';

if ($connection) {
    $text_score = mysqli_real_escape_string($connection, $_POST['text_score']);
    $score = mysqli_real_escape_string($connection, $_POST['score']);
    $checklist_type = mysqli_real_escape_string($connection, $_POST['checklist_type']);
    $score_id = mysqli_real_escape_string($connection, $_POST['score_id']);
    $detail_checklist = mysqli_real_escape_string($connection, $_POST['detail_checklist']);


    $condition = "";
    if ($checklist_type == 1) {
        $condition = "text_score = '$text_score'";
    } else if ($checklist_type == 3) {
        $condition = "score = '$score'";
    }

    $checklist_check = "SELECT * FROM tbl_qc_record WHERE job_qc_id = '$job' AND checklist_id = '$checklist_id'";
    $res_check = mysqli_query($connection, $checklist_check);
    if (mysqli_num_rows($res_check) < 1) {
        $sql_insert = "INSERT INTO tbl_qc_record SET  
        record_id = '$record_id',
        score_id = '$score_id',
        detail_checklist = '$detail_checklist',
        job_qc_id = '$job',
        checklist_id = '$checklist_id',$condition";
    } else {
        $sql_insert = "UPDATE tbl_qc_record SET 
        score_id = '$score_id',
        detail_checklist = '$detail_checklist',
            $condition
            WHERE record_id = '$record_id'";
    }
    $res_insert = mysqli_query($connection, $sql_insert) or die($connection->error);
    if ($res_insert) {

        if (is_array($_FILES['produce_img'])) {
            $list = 1;
            foreach ($_FILES['produce_img']['name'] as $name => $value) {
                if ($_FILES['produce_img']['name'][$name] == "") {
                    $arr['result'] = 2; /// ไม่มีรูป insert success
                }

                $tmpFilePath_1 = $_FILES['produce_img']['tmp_name'][$name];
                $file_1 = explode(".", $_FILES['produce_img']['name'][$name]);
                $count1 = count($file_1) - 1;
                $file_surname_1 = $file_1[$count1];
                $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;
                if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG' || $file_surname_1 == 'PDF' || $file_surname_1 == 'pdf') {
                    if (move_uploaded_file($tmpFilePath_1, "../../upload/qc_img/" . $filename_images_1)) {

                            // $file_Path = __DIR__ . '../../upload/qc_img/' . $filename_images_1;
                            $file_Path  = "../../upload/qc_img/" . $filename_images_1;
                            $key = basename($file_Path);
                            $bucket;
                            $result = $s3Client->putObject([
                                'Bucket' => $bucket,
                                'Key' => $key,
                                'Body' => fopen($file_Path, 'r'),
                                'ACL' => 'public-read', // make file 'public'
                            ]);

                            $urlFile = $result->get('ObjectURL');

                        $sql_chk = "SELECT * FROM tbl_qc_record_img WHERE record_id = '$record_id' AND list_order = '$list'";
                        $res_chk = mysqli_query($connection, $sql_chk);
                        $row_chk = mysqli_fetch_assoc($res_chk);
                        $num_chk = mysqli_num_rows($res_chk);
                        // echo $num_chk;
                        if ($num_chk < 1) {
                            $record_img_id = getRandomID2(10, 'tbl_qc_record_img', 'record_img_id');
                            $sql_img = "INSERT INTO tbl_qc_record_img SET record_img_id = '$record_img_id', record_id = '$record_id',file_part = '$filename_images_1',list_order = '$list'";
                        } else {

                            $row_chk['record_img_id'];
                            $sql_img = "UPDATE tbl_qc_record_img SET  file_part = '$filename_images_1' WHERE record_img_id = '{$row_chk['record_img_id']}'";
                        }

                        $res_img = mysqli_query($connection, $sql_img) or die($connection->error);

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
