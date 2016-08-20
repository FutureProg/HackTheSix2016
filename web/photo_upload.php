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
    if(move_uploaded_file($_FILES[0]['tmp_name'],$destination)){
      if(addToDB($name,$rating,$destination)){
	echo $destination;      
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
function addToDB($name,$rating,$url){
  $db = new ImageDB();
  if(!$db){
    
  }
  $res = $db->addImage($name,$name,$rating,$url);//TODO: Change to identified name
  
}

/**
 * TODO: Identify function that returns the result of the 
 * image analysis
 */
function identify($url){
  
}

?>
