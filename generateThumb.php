<?php require_once("config.php") ?>
<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
	$file = $_FILES["fileUpload"];
	$resizeValue = $_POST["resizeValue"];
	extract($file);
	if($name !== ""){
		$target = new Image($name,$type,$tmp_name,$error,$size,$resizeValue);
		$target->uploadImage();		
	}	
}
?>