<?php
include 'database.php';

function setImage($name,$rating){
  $picturename = $_FILES[0]['name'];
  if(sizeof($_FILES[0] > 0) && $_FILES[0]['error'] == 0){
    $basename = basename($_FILES[0]['tmp_name']);
    $imgloc = "images/";
    if(!file_exists($imgloc)){
      mkdir($imgloc,0777,true) or die("ERROR: Unable to create directory \"$imgloc\"");
      chmod($imgloc,777);
    }
    $picturename = $basename . $picturename;
    $destination = $imgloc . $picturename;
    if(move_uploaded_file($_FILES[0]['tmp_name'],$destination)){ //upload image to server
      $identity = identify($destination);
      $actualname = $name;//$identity[0];
      $res = rename($destination,$destination."|".$actualname."|".$rating); //rename to proper name
      if($res == true){	
	$res = true;//addToDB($actualname,$name,$rating,$destination); //add the image to the database
	if($res){
	  echo "[".$destination."|".$actualname."|".$rating;
	  return $identity;
	}else{
	  echo "ERROR: Unable to move to proper name"; //unable to add to database
	}
      }else{
	echo $res; //unable to rename
      }
      return;
    }else{ 
      echo "ERROR: unable to move file to destination during upload";
    }
  }else{
    echo "ERROR: An error occured during file upload";
  }
}

/**
 * Function to upload to database
 */
function addToDB($actualname,$name,$rating,$url){
  $db = new ImageDB();
  if(!$db){
    return "Error creating database class";
  }
  $res = $db->addImage($actualname,$name,$rating,$url);//TODO: Change to identified name  
  $db->close();
  return $res;
}

/**
 * TODO: Identify function that returns the result of the 
 * image analysis
 */
function identify($url){
  $cmd = escapeshellcmd("python ../clothing_similarity-skeleton/ML_matching_clothing.py");
  //echo $cmd." ../web/$url";
  $res = shell_exec($cmd." ../web/$url");
  $res = file_get_contents("outFile");
  //  $res = json_decode($res);//explode(",",substr(substr($res,strlen($res)-1),1));//make array from [..,...,..]
  return $res;
}

?>
