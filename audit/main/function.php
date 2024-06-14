<?php

use Aws\Exception\MultipartUploadException;

use Aws\S3\MultipartUploader;

use Aws\S3\S3Client;


function s3Key()
{
    return array(
        'bucket' => '',
        'AccessID' => '',
        'Secret' => '',
        'Region' => 'ap-southeast-1',
    );
}

function awsCredential($type = 'credentials')

{
    $arrayKey = s3Key();
    $bucket = $arrayKey['bucket'];
    $AccessID = $arrayKey['AccessID'];
    $Secret = $arrayKey['Secret'];
    $Region = $arrayKey['Region'];

    $credentials = new Aws\Credentials\Credentials($AccessID, $Secret);



    if ($type == 'bucket'){

        return $bucket;

    }



    return $credentials;

}



function generateFileKey($folder = null, $length = 32){

    if (empty($folder)){

        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);

    } else {

        return $folder."/".substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);

    }

}



function uploadFileDirectly($file,$is_public = true,$folder = null){

    $arrayKey = s3Key();
    $bucket = $arrayKey['bucket'];
    $AccessID = $arrayKey['AccessID'];
    $Secret = $arrayKey['Secret'];
    $Region = $arrayKey['Region'];

    try {

        $s3Client = new S3Client([

            'version' => 'latest',

            'region' => $Region,

            'credentials' => awsCredential(),

        ]);



        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        $upload_path = generateFileKey($folder).".".$ext;



        $data = [

            'bucket' => awsCredential('bucket'),

            'key' => $upload_path,

            'params' => [

                'ContentType' => $file['type'],

            ]

        ];



        if ($is_public){

            $data['ACL'] = 'public-read';

        }



        $uploader = new MultipartUploader($s3Client, $file['tmp_name'], $data);



        try {

            $result = $uploader->upload();

            return [

                'url' => $result['ObjectURL'],

                'path' => $upload_path,

                'is_public' => $is_public

            ];

        } catch (MultipartUploadException $e) {

            return [

                'url' => null,

                'path' => null,

                'is_public' => $is_public

            ];

        }

    } catch (Exception $exception) {

        return [

            'url' => null,

            'path' => null,

            'is_public' => $is_public

        ];

    }

}



function uploadFileByPath($path,$is_public = true,$folder = null){

    $arrayKey = s3Key();
    $bucket = $arrayKey['bucket'];
    $AccessID = $arrayKey['AccessID'];
    $Secret = $arrayKey['Secret'];
    $Region = $arrayKey['Region'];

    try {

        $s3Client = new S3Client([

            'version' => 'latest',

            'region' => $Region,

            'credentials' => awsCredential(),

        ]);



        // $ext = pathinfo($path, PATHINFO_EXTENSION);

        // $upload_path = generateFileKey($folder).".".$ext;
        // $upload_path = str_replace(['/','"','?','*','<','>','\\'],$path);

        $fileArray = explode('/',$path);

        $upload_path = end($fileArray);

        $data = [

            'Bucket' => awsCredential('bucket'),

            'Key' => $upload_path,

            'SourceFile' => $path

        ];



        if ($is_public){

            $data['ACL'] = 'public-read';

        }



        $result = $s3Client->putObject($data);



        return [

            'url' => $result['ObjectURL'],

            'path' => $upload_path,

            'is_public' => $is_public

        ];

    } catch (Exception $exception) {

        return [

            'url' => null,

            'path' => null,

            'is_public' => $is_public

        ];

    }

}



function getFileUrl($path,$expire_in = '+30 minutes')

{

    $arrayKey = s3Key();
    $bucket = $arrayKey['bucket'];
    $AccessID = $arrayKey['AccessID'];
    $Secret = $arrayKey['Secret'];
    $Region = $arrayKey['Region'];

    try {

        $s3Client = new S3Client([

            'version' => 'latest',

            'region' => $Region,

            'credentials' => awsCredential(),

        ]);



        $cmd = $s3Client->getCommand('GetObject', [

            'Bucket' => awsCredential('bucket'),

            'Key' => $path,

            'ACL' => 'public-read'

        ]);



        $request = $s3Client->createPresignedRequest($cmd, $expire_in);

        $presignedUrl = (string)$request->getUri();



        return $presignedUrl;

    } catch (Exception $exception) {

        return $exception;

    }

}



function deleteFile($path)

{

    $arrayKey = s3Key();
    $bucket = $arrayKey['bucket'];
    $AccessID = $arrayKey['AccessID'];
    $Secret = $arrayKey['Secret'];
    $Region = $arrayKey['Region'];

    try {

        $s3Client = new S3Client([

            'version' => 'latest',

            'region' => $Region,

            'credentials' => awsCredential(),

        ]);



        $s3Client->deleteObject([

            'Bucket' => awsCredential('bucket'),

            'Key' => $path

        ]);



        return true;

    } catch (Exception $exception) {

        return false;

    }

}



function deleteFileByURL($url){
    
    $arrayKey = s3Key();
    $bucket = $arrayKey['bucket'];
    $AccessID = $arrayKey['AccessID'];
    $Secret = $arrayKey['Secret'];
    $Region = $arrayKey['Region'];

    try {

        $s3Client = new S3Client([

            'version' => 'latest',

            'region' => $Region,

            'credentials' => awsCredential(),

        ]);



        $url_data = parse_url($url);

        $path = $url_data['path'];



        $s3Client->deleteObject([

            'Bucket' => awsCredential('bucket'),

            'Key' => ltrim($path, '/')

        ]);



        return true;

    } catch (Exception $exception) {

        return false;

    }

}



function curlPost($data){

    $ch = curl_init('https://webhook.site/3dbfd4f5-374b-43e3-8e7a-f88451eaaebc?data='.$data);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

}



?>

