<?php

class PHPUploader {

	private $destinationPath;
	private $errorMessage;
	private $extensions;
	private $allowAll;
	private $maxSize;
	private $uploadName;

	public function __construct()
	{
		$this->maxSize = (min((int) ini_get('post_max_size'), (int) ini_get('upload_max_filesize')) * 1024 * 1024);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      // server max upload size in bits
		$this->extensions = ['aac' => 'audio/aac', 'ai' => 'application/postscript', 'avi' => 'video/x-msvideo', 'bmp' => 'image/bmp', 'class' => 'application/octet-stream', 'css' => 'text/css', 'csv' => 'text/csv', 'dll' => 'application/octet-stream', 'dmg' => 'application/octet-stream', 'doc' => 'application/msword', 'dvi' => 'application/x-dvi', 'eps' => 'application/postscript', 'exe' => 'application/octet-stream', 'gif' => 'image/gif', 'htm' => 'text/html', 'html' => 'text/html', 'ico' => 'image/x-icon', 'jpe' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'js' => 'application/x-javascript', 'json' => 'application/json', 'mov' => 'video/quicktime', 'movie' => 'video/x-sgi-movie', 'mp2' => 'audio/mpeg', 'mp3' => 'audio/mpeg', 'mpe' => 'video/mpeg', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg', 'mpga' => 'audio/mpeg', 'ogg' => 'application/ogg', 'pdf' => 'application/pdf', 'png' => 'image/png', 'php' => 'application/x-httpd-php', 'ppt' => 'application/vnd.ms-powerpoint', 'ps' => 'application/postscript', 'rar' => 'application/vnd.rar', 'rgb' => 'image/x-rgb', 'rss' => 'application/rss+xml', 'svg' => 'image/svg+xml', 'svgz' => 'image/svg+xml', 'swf' => 'application/x-shockwave-flash', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'txt' => 'text/plain', 'vcd' => 'application/x-cdlink', 'wav' => 'audio/x-wav', 'wmv' => 'video/x-ms-wmv', 'wbmp' => 'image/vnd.wap.wbmp', 'wbxml' => 'application/vnd.wap.wbxml', 'xhtml' => 'application/xhtml+xml', 'xls' => 'application/vnd.ms-excel', 'xml' => 'application/xml', 'xsl' => 'application/xml', 'xul' => 'application/vnd.mozilla.xul+xml', 'zip' => 'application/zip', '7z' => 'application/x-7z-compressed', 'sql' => 'text/x-Algol68']; // some default extensions
	}


	function setDir($path)
	{
		$this->destinationPath = $path;
		$this->allowAll = false;
	}

	function allowAllFormats()
	{
		$this->allowAll = true;
	}

	function setMaxSize($sizeMB)
	{
		// if max size is not greater than server max post size
		if ((!$sizeMB * (1024 * 1024)) > $this->maxSize) {
			$this->maxSize = $sizeMB * (1024 * 1024);
		}
	}

	function setExtensions($extensions_array)
	{
		$this->extensions = $extensions_array;
	}

	function getMessage()
	{
		return $this->errorMessage;
	}

	function getUploadName()
	{
		return $this->uploadName;
	}

	function uploadFile($fileBrowse)
	{
		$result = false;
		$size = $_FILES[$fileBrowse]["size"];
		$name = $_FILES[$fileBrowse]["name"];
		$tmp_name = $_FILES[$fileBrowse]["tmp_name"];
		$ext = $this->getExtension($name);
		if (!is_dir($this->destinationPath)) {
			$this->setMessage("Destination folder is not a directory ");
		} else if (!is_writable($this->destinationPath)) {
			$this->setMessage("Destination is not writable !");
		} else if (empty($name)) {
			$this->setMessage("File not selected ");
		} else if ($size > $this->maxSize) {
			$this->setMessage("Too large file ! max size is {$this->maxSize}");
		} else if ($this->allowAll || (!$this->allowAll && $this->checkMIMEType($tmp_name))) {

			if ($this->existsFile($name)) {
				$this->uploadName = $this->getOnlyFileName($name) . '__' . $this->getRandom() . "." . $ext;
			} else {
				$this->uploadName = $name;
			}
			if (move_uploaded_file($tmp_name, $this->destinationPath . $this->uploadName)) {
				$result = true;
			} else {
				$this->setMessage("Upload failed , try later !");
			}
		} else {
			$this->setMessage("Invalid file format !");
		}

		return $result;
	}

	function getExtension($fileName)
	{
		return pathinfo($fileName, PATHINFO_EXTENSION);
	}

	function setMessage($message)
	{
		$this->errorMessage = $message;
	}

	public function checkMIMEType($tmp_name)
	{
		// Check MIME Type by yourself.
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		if (!in_array($finfo->file($tmp_name), $this->extensions, true)) {
			return false;
		}

		return true;
	}

	function existsFile($fileName)
	{

		if (file_exists($this->destinationPath . $fileName)) {
			return true;
		}

		return false;
	}

	function getOnlyFileName($fullName)
	{
		return pathinfo($fullName, PATHINFO_FILENAME);
	}

	function getRandom()
	{
		return bin2hex(random_bytes(3));
	}

	function deleteUploaded()
	{
		unlink($this->destinationPath . $this->uploadName);
	}

}

?>