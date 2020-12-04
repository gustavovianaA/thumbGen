<?php
spl_autoload_register(function($className){
if(file_exists("Class" . 	DIRECTORY_SEPARATOR . $className.".php")){
	require_once("Class" . 	DIRECTORY_SEPARATOR . $className.".php");}
});
?>