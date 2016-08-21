<?php
include 'photo_upload.php';
include 'recommendations.php';

if(isset($_GET['RECOMMEND'])){
  $rating = filter_input(INPUT_POST,'RATING');
  $name = filter_input(INPUT_POST,'NAME');
  $identity = setImage($name,$rating);
  echo ",".json_encode($identity)."]";
}

?>