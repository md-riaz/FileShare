<?php
header('Access-Control-Allow-Origin: *');
function formatSizeUnits($size)
{
	$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	$power = $size > 0 ? floor(log($size, 1024)) : 0;

	return number_format($size / (1024 ** $power), 2, '.', ',') . ' ' . $units[$power];
}

$fileList = [];
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$resource = getcwd() . '/shared_files';
$files = glob($resource . '/*.*');
// sorting files with modified date
usort($files, function ($file1, $file2) {
	return filemtime($file1) < filemtime($file2);
});
$max_upload = (min((int) ini_get('post_max_size'), (int) ini_get('upload_max_filesize')) * 1024 * 1024); // max upload size in bits

foreach ($files as $file) {
	$filename = pathinfo($file, PATHINFO_BASENAME);
	$filesize = formatSizeUnits(filesize($file));
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	$imgExt = ['jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'gif', 'bmp', 'svg', 'webp'];
	if ((in_array($ext, $imgExt))){
		$previewUrl = dirname($url) . "/shared_files/{$filename}";
	} elseif (file_exists(dirname($url, 2) . "/assets/file_icons/{$ext}.png")){
		$previewUrl = dirname($url, 2) . "/assets/file_icons/{$ext}.png";
	} else {
		$previewUrl = dirname($url, 2) . "/assets/file_icons/nofile.png";
	}
	$hrefUrl = ($ext === 'php' ? dirname($url, 2) . '/download.php?file=' . $filename : dirname($url) . '/shared_files/' . $filename);
	$downloadUrl = dirname($url, 2) . "/download.php?file={$filename}";
	$fileList[] = [
		'filename'        => $filename,
		'size'            => $filesize,
		'hrefUrl'         => $hrefUrl,
		'downloadUrl'     => $downloadUrl,
		'previewUrl' => $previewUrl
	];

}

echo json_encode($fileList);
exit();
?>