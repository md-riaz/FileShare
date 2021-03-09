<?php
$FILE = $_FILES['file_input'];
$max_upload = (min((int) ini_get('post_max_size'), (int) ini_get('upload_max_filesize')) * 1024 * 1024); // max upload size in bits
$Cryptograph_alphanumeric =  '__'.bin2hex(random_bytes(3)) ;
$validMIMETypes = [
	'aac'   => 'audio/aac',
	'ai'    => 'application/postscript',
	'avi'   => 'video/x-msvideo',
	'bmp'   => 'image/bmp',
	'class' => 'application/octet-stream',
	'css'   => 'text/css',
	'csv'   => 'text/csv',
	'dll'   => 'application/octet-stream',
	'dmg'   => 'application/octet-stream',
	'doc'   => 'application/msword',
	'dvi'   => 'application/x-dvi',
	'eps'   => 'application/postscript',
	'exe'   => 'application/octet-stream',
	'gif'   => 'image/gif',
	'htm'   => 'text/html',
	'html'  => 'text/html',
	'ico'   => 'image/x-icon',
	'jpe'   => 'image/jpeg',
	'jpeg'  => 'image/jpeg',
	'jpg'   => 'image/jpeg',
	'js'    => 'application/x-javascript',
	'json'  => 'application/json',
	'mov'   => 'video/quicktime',
	'movie' => 'video/x-sgi-movie',
	'mp2'   => 'audio/mpeg',
	'mp3'   => 'audio/mpeg',
	'mpe'   => 'video/mpeg',
	'mpeg'  => 'video/mpeg',
	'mpg'   => 'video/mpeg',
	'mpga'  => 'audio/mpeg',
	'ogg'   => 'application/ogg',
	'pdf'   => 'application/pdf',
	'png'   => 'image/png',
	'php'   => 'application/x-httpd-php',
	'ppt'   => 'application/vnd.ms-powerpoint',
	'ps'    => 'application/postscript',
	'rar'   => 'application/vnd.rar',
	'rgb'   => 'image/x-rgb',
	'rss'   => 'application/rss+xml',
	'svg'   => 'image/svg+xml',
	'svgz'  => 'image/svg+xml',
	'swf'   => 'application/x-shockwave-flash',
	'tif'   => 'image/tiff',
	'tiff'  => 'image/tiff',
	'txt'   => 'text/plain',
	'vcd'   => 'application/x-cdlink',
	'wav'   => 'audio/x-wav',
	'wmv'   => 'video/x-ms-wmv',
	'wbmp'  => 'image/vnd.wap.wbmp',
	'wbxml' => 'application/vnd.wap.wbxml',
	'xhtml' => 'application/xhtml+xml',
	'xls'   => 'application/vnd.ms-excel',
	'xml'   => 'application/xml',
	'xsl'   => 'application/xml',
	'xul'   => 'application/vnd.mozilla.xul+xml',
	'zip'   => 'application/zip',
	'7z'    => 'application/x-7z-compressed',
	'sql'   => 'text/x-Algol68'
];
$upload_path = 'shared_files/';

try {
	if (!isset($FILE['error']) || is_array($FILE['error'])) {
		throw new RuntimeException('Invalid File.');
	}

	switch ($FILE['error']) {
		case UPLOAD_ERR_OK:
			break;
		case UPLOAD_ERR_NO_FILE:
			throw new RuntimeException('No file sent.');
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			throw new RuntimeException('Exceeded filesize limit.');
		default:
			throw new RuntimeException('Unknown errors.');
	}

	$file_name = pathinfo($FILE['name'], PATHINFO_FILENAME);
	$file_ext = pathinfo($FILE['name'], PATHINFO_EXTENSION);
	$tmp_location = $FILE['tmp_name'];
	$destination = (file_exists($upload_path.$file_name.'.'.$file_ext)) ? $upload_path.$file_name.$Cryptograph_alphanumeric.'.'.$file_ext : $upload_path.$file_name.'.'.$file_ext;

	// You should also check filesize here.
	if ($FILE['size'] > $max_upload) {
		throw new RuntimeException('Exceeded filesize limit.');
	}

	// Check MIME Type by yourself.
	$finfo = new finfo(FILEINFO_MIME_TYPE);
	if (!in_array($finfo->file($FILE['tmp_name']), $validMIMETypes, true)) {
		throw new RuntimeException('Invalid file format.');
	}


	if (!move_uploaded_file($tmp_location,$destination)) {
		throw new RuntimeException('Failed to move uploaded file.');
	}

	echo json_encode(['status' => 200, 'message' => 'File is uploaded successfully.']);

} catch (RuntimeException $e) {

	echo json_encode(['status' => 400, 'message' => $e->getMessage()]);

}

// Email system to receive the notifications
// $to = 'bpimdriaz@gmail.com';
// $datetime = date("F j, Y, g:i a");
// $subject = 'New Visitor uploaded a file on your Webpage';
// $emailContent = "<h3>Someone uploaded a file.</h3>
// 			Time: " . $datetime . "
// 			File : " . $Cryptograph_alphanumeric . $file['name'];
// headers
// $headers = "MIME-Version: 1.0\r\n";
// $headers .= "Content-Type: text/html; charset=utf-8";
// send the message
// mail($to, $subject, $emailContent, $headers);
?>