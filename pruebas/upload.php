<?php
  // get details of the uploaded file
  $fileTmpPath = $_FILES['file']['tmp_name'];

  // directory in which the uploaded file will be moved
  $uploadFileDir = './img/';
  $dest_path = $uploadFileDir . $_FILES['file']['name'] ;
  
  if(move_uploaded_file($fileTmpPath, $dest_path))
  {
    $message =true;
  }
  else
  {
    $message = false;
  }
  echo $message;
?>