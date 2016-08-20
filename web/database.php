<?php

class ImageDB extends SQLite3{

  function __construct(){
    $this->open("images.db");
  }

  function addImage($name,$givenname,$rating,$path){
    $query = "INSERT INTO Images (name,given_name,rating,path)"
      ." VALUES ($name,$givenname,$rating,$path);";
    $re = $this->exec($query);
    if(!$re){
      return $this->lastErrorMsg();
    } else {
      return true;
    }
  }

  function findImages($name){
    $query ="SELECT * FROM Images WHERE name=$name;";
    $re = $this->exec($query);
    if(!$re){
      return $this->lastErrorMsg();
    }else{
      return true;
    }
  }
  
}

$db = new ImageDB();
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Opened database successfully\n";
}