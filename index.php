<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title>FileShare</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Katibeh&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<div class="page_wrapper">
    <h1>FileShare List</h1>
    <!--  Check folder and read content -->
    <div class="file_list">
		<?php
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$resource = getcwd() . '/upload/shared_files';
		$files = glob($resource . '/*.*');
		// sorting files with modified date
		usort($files, function ($file1, $file2) {
			return filemtime($file1) < filemtime($file2);
		});
		$max_upload = (min((int) ini_get('post_max_size'), (int) ini_get('upload_max_filesize')) * 1024 * 1024); // max upload size in bits

		foreach ($files as $file) {
			$filename = pathinfo($file, PATHINFO_BASENAME);
			$filenameEncoded = urlencode(str_rot13($filename));
			$filesize = formatSizeUnits(filesize($file));
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$imgExt = ['jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'gif', 'bmp', 'svg', 'webp'];
			$previewUrl = (in_array($ext, $imgExt)) ? "upload/shared_files/{$filename}" : "file_icons/{$ext}.png";
			$hrefUrl = ($ext = 'php' ? $url.'download.php?file='.$filenameEncoded : $url.'/upload/shared_files/'.$filename);
			echo "
                    <a class='content_file' href='{$hrefUrl}' data-href='{$url}download.php?file={$filenameEncoded}' title='{$filename}'>
                      <img src='{$previewUrl}' alt='{$filename}'>
                      <span class='file_name'>{$filename}</span>
                      <span class='file_size'>{$filesize}</span>
                    </a>
                  ";
		}
		?>
    </div>
</div>
<a class="upload_btn" href="upload/">Upload Now</a>
<script src="assets/app.js"></script>
</body>

</html>

<?php
function formatSizeUnits($size)
{
	$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	$power = $size > 0 ? floor(log($size, 1024)) : 0;

	return number_format($size / (1024 ** $power), 2, '.', ',') . ' ' . $units[$power];
}

?>