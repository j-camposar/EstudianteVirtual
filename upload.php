<?php
  // get details of the uploaded file
  $fileTmpPath = $_FILES['file']['tmp_name'];

  $rut=$_GET['nombre'];
  
  $fileName = $rut;
  // directory in which the uploaded file will be moved
  $uploadFileDir = './Documentos/';
  $dest_path = $uploadFileDir .$fileName ;
  
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