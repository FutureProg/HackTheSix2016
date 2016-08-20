<?php

class ImageDB extends SQLite3{

  function __construct(){
    $this->open("images.db");
  }
  
}

$db = new ImageDB();
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Opened database successfully\n";
}


