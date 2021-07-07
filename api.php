<?php 
include 'google-api-php-client/vendor/autoload.php';

$archivo= $_FILES['file-es'];
$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] ;
$client = new Google_Client();

// Get your credentials from the console
$client->setAuthConfig("Documentos/estudiantevirtual-a7d885bee1c1.json");
$client->setRedirectUri($redirect_uri);
$client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
//instanciamos el servicio
$service = new Google_Service_Drive($client);

//instacia de archivo
$file = new Google_Service_Drive_DriveFile();
//ruta al archivo
$cont=0;
try {
    for($i=0; $i < count($archivo["name"]); $i++){
        $nombre=$archivo["name"][$i];
        $file_path = $archivo["tmp_name"][$i];
        //obtenemos el mime type
        $finfo=finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo,$file_path);
        //id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
        $file->setParents(array("16iE-MK732eHEOUYxnCuIfrdofc0MXBH5"));
        //nombre del archivo
        $file->setName($nombre);
        $file->setDescription('Archivo subido desde Estudiante Virtual');
        $file->setMimeType($mime_type);

        $result = $service->files->create(
            $file,
            array(
            'data' => file_get_contents($file_path),
            'mimeType' => $mime_type,
            'uploadType' => 'Resumable'
            )
        );
        //link de archivoz
        $links[$cont]["code"]=$result->id;
        $cont++;
    }
    $respuestas = array();
    $respuestas = ['dirupload' => $redirect_uri, 'total'=>$cont, 'code'=> $links]; 
    echo json_encode($respuestas);
}catch(Google_Service_Exception $op){
    $mensaje=json_decode($op->getMessage());
    echo $mensaje->error->message();
}catch(Exception $e){
    echo $e->getMessage();
}
    ?>