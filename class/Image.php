<?php
class Image{
	private $name;
	private $ext;
	private $tmpName;
	private $error;
	private $size;
	private $resizeValue;

	private $valid=true;
	private $validExtensions = ["png","jpeg"];

	public function __get($prop) {
		return $this->$prop;
	}

	public function setName($name){
		$this->name = $name;
	}
	public function setExt($type){
		$ext = explode("/", $type)[1];
		if(in_array($ext,$this->validExtensions)){
			$this->ext = $ext;	
		}else{
			$this->valid=false;
		}

	}
	public function setTmpName($tmpName){
		$this->tmpName = $tmpName;
	}
	public function setError($error){
		$this->error = $error;
		if($this->error != "")
			$this->valid=false; 
	}
	public function setSize($size){
		$this->size = $size;
	}
	public function setResizeValue($resizeValue){
		$this->resizeValue = $resizeValue/100;
	}

	public function uploadImage(){
		if($this->valid){
			$dirUploads = "img";
			if(!is_dir($dirUploads))
				mkdir($dirUploads);
			move_uploaded_file($this->tmpName,$dirUploads . DIRECTORY_SEPARATOR . $this->name);
			$this->generateThumb($dirUploads,$this->name);
		}
	}

	private function generateThumb($dir,$file){
		$origin = $dir . DIRECTORY_SEPARATOR . $file;
		$destination = $dir . DIRECTORY_SEPARATOR . "thumb";
		if(!is_dir($destination))
			mkdir($destination);	
		list($old_width,$old_heigth) = getimagesize($origin);
		$newSize = ["w"=>$old_width*$this->resizeValue , "h"=>$old_heigth*$this->resizeValue];
		$newImage = imagecreatetruecolor($newSize["w"], $newSize["h"]);
		$oldImage = imagecreatefromstring(file_get_contents($origin));
		imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $newSize["w"], $newSize["h"], $old_width, $old_heigth);
		$newName = $this->resizeValue . $file;
		imagejpeg($newImage ,$destination . DIRECTORY_SEPARATOR . $newName, 90);	
		imagedestroy($oldImage);
		imagedestroy($newImage);
		if(file_exists($destination . DIRECTORY_SEPARATOR . $newName)){
			echo "<a href='" . $destination . DIRECTORY_SEPARATOR . $newName . "' download><h2>Thumb: ".$this->resizeValue*100 ."%</h2><h2>Download</h2><img src='".$destination . DIRECTORY_SEPARATOR . $newName."'></a>";  
			$img = scandir($destination);
			foreach ($img as $name) {
				if($name !== $newName && !in_array($name, [".",".."]))
					unlink($destination . DIRECTORY_SEPARATOR . $name);		
			}
		}
	}

	public function __construct($name,$type,$tmpName,$error,$size,$resizeValue){
		$this->setName($name);
		$this->setExt($type);
		$this->setTmpName($tmpName);
		$this->setError($error);
		$this->setSize($size);
		$this->setResizeValue($resizeValue);
	}
}
?>