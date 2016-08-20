<?php

class ImageDB extends SQLite3{

  function __construct(){
    $this->open("images.db");
  }

  function addImage($name,$givenname,$rating,$path){
    $query =<<<EOF
      INSERT INTO Images (name,given_name,rating,path)
      VALUES ($name,$givenname,$rating,$path);
    EOF;
    $re = $this->exec($query);
    if(!$re){
      echo $this->lastErrorMsg();
    } else {
      echo "OKAY";
    }
  }

  function findImages($name){
    $query =<<<EOF
      SELECT * FROM Images WHERE name=$name;
    EOF;
    $re = $this->exec($query);
    if(!$re){
      echo $this->lastErrorMsg();
    }else{
      echo "OKAY";
    }
  }
  
}

$db = new ImageDB();
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Opened database successfully\n";
}


