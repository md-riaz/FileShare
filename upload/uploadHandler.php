<?php
header('Access-Control-Allow-Origin: *');
require_once('PHPUploader.php');

$unique_id = $_POST['id'];
$uploader = new PHPUploader();
$uploader->setDir('shared_files/');

$uploader->setMaxSize(20); //set max file size to be allowed in MB

$result = $uploader->uploadFile('file_input'); //file_input is the filebrowse element name

if ($result) {

	echo json_encode([
		'id' => $unique_id,
		'status'  => 200,
		'message' => 'File is uploaded successfully.'
	]);
	exit;
}

//upload failed || get upload error message
echo json_encode([
	'id' => $unique_id,
	'status'  => 400,
	'message' => $uploader->getMessage()
]);
exit;

?>