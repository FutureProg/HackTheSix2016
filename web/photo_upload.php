<?php

function setImage(){
  var_dump($_FILES);
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
      echo $destination;
      return;
    }else{
      echo "ERROR: unable to move file to destination during upload";
    }
  }else{
    echo "ERROR: An error occured during file upload";
  }
}

/**
 * TODO: Identify function that returns the result of the 
 * image analysis
 */
function identify(){
  
}

?>
