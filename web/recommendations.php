<?php

function getRecommendations($imgPath,$rating,$name){

  $cmd = escapeshellcmd("python3 recommend.py");
  $cmd .= " $imgPath";
  $output = shell_exec($cmd);
  return $output;
  
}

?>