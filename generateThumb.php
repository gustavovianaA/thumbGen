<?php
spl_autoload_register(function($className){
if(file_exists("Class" . 	DIRECTORY_SEPARATOR . $className.".php")){
	require_once("Class" . 	DIRECTORY_SEPARATOR . $className.".php");}
});
if($_SERVER["REQUEST_METHOD"] === "POST"){
	if(empty($_FILES["fileUpload"]["name"]))
		die();
	$file = $_FILES["fileUpload"];
	$resizeValue = $_POST["resizeValue"];
	extract($file);
	if($name !== ""){
		$target = new Image($name,$type,$tmp_name,$error,$size,$resizeValue);
		$target->uploadImage();		
	}	
}
?>