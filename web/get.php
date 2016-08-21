<?php
include 'photo_upload.php';
include 'recommendations.php';

if(isset($_GET["UPLOAD_TEST"])){
  echo setImage();
}

if(isset($_GET['RECOMMEND'])){
  $rating = filter_input(INPUT_GET,'RATING');
  $name = filter_input(INPUT_GET,'NAME');
  $identity = setImage($name,$rating);
  echo ","+$identity+"]";
}

?>