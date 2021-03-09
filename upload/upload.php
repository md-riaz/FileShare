<?php
require_once('PHPUploader.php');

$uploader = new PHPUploader();
$uploader->setDir('shared_files/');

$uploader->setMaxSize(8);       //set max file size to be allowed in MB//
$result = $uploader->uploadFile('file_input');
if ($result) {      //file_input is the filebrowse element name //
	echo json_encode(['status' => 200, 'message' => 'File is uploaded successfully.']);
	exit;
}

//upload failed
//get upload error message
echo json_encode(['status' => 400, 'message' => $uploader->getMessage()]);
exit;

?>