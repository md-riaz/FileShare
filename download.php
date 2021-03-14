<?php
header('Access-Control-Allow-Origin: *');
$file_name =  urldecode($_GET['file']);
$file_path = getcwd() . '/upload/shared_files/' . $file_name;

if (file_exists($file_path)) {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file_path));
  flush(); // Flush system output buffer
  readfile($file_path);
  die();
}

http_response_code(404);
die();
