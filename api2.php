<?php session_start();

//incluir la libreria del cliente de google php
include 'google-api-php-client/vendor/autoload.php';

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] ;
//crear y configurar el objeto cliente
$cliente = new Google_Client();
$cliente->setRedirectUri('http://' . $_SERVER['HTTP_HOST']);
$cliente->setAuthConfig("Documentos/estudiantevirtual-a7d885bee1c1.json");
$cliente->SetScopes(['https://www.googleapis.com/auth/drive.file']);

//proceso para leer un archivo por pedazos
function leerPorPedazos($fp, $bytesDelPedazo){
    $totalBytes = 0;
    $pedazoGigante = "";
    while (!feof($fp)) {
        $pedazo = fread($fp, 8192);
        $totalBytes += strlen($pedazo);
        $pedazoGigante .= $pedazo;
        if ($totalBytes >= $bytesDelPedazo) {
            return $pedazoGigante;
        }
    }
    return $pedazoGigante;
}
$archivo= $_FILES['file-es'];
$cont=0;
for($i=0; $i < count($archivo["name"]); $i++){
    $servicio = new Google_Service_Drive($cliente); // definir el serivico que se está solicitando
    $archivoLocal = $archivo["tmp_name"][$i]; // definimos la ruta del archivo a cargar

    //preparar el archivo drive
    $archivoDrive = new Google_Service_Drive_DriveFile(
        array(
            'name' => $archivo["name"][$i],
            'parents' => array("16iE-MK732eHEOUYxnCuIfrdofc0MXBH5")
        )
    );
    $bytesDelPedazo = 1 * 1024 * 1024; //128Kbs
    $finfo=finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo,$archivoLocal);
    //configurar los parámetros opcionales
    $paramsOpc = array(
        'fields' => '*'
    );

    //llamar a la api y configurar al cliente diferido para que no regrese inmediatamente
    $cliente->setDefer(true);
    $solicitud = $servicio->files->create($archivoDrive, $paramsOpc);

    //crear una carga de archivo multimedia para representar el proceso de carga
    $multimedia = new Google_Http_MediaFileUpload(
        $cliente,
        $solicitud,
        $mime_type,
        null,
        true,
        $bytesDelPedazo
    );
    $multimedia->setFileSize(filesize($archivoLocal));

    //cargamos todos los pedazos. $estado será false hasta que el proceso esté completo
    $estado = false;
    $fp = fopen($archivoLocal, "rb");
    while (!$estado && !feof($fp)) {
        // leemos hasta que dejamos de obtener $bytesDelPedazo del $archivoLocal
        $pedazo = leerPorPedazos($fp, $bytesDelPedazo);
        $estado = $multimedia->nextChunk($pedazo);
    }

    $cliente->setDefer(false);    
    //var_dump($estado);
       //link de archivoz
    $links[$cont]["code"]=$estado->id;
    $cont++;
}
    $respuestas = array();
    $respuestas = ['dirupload' => $redirect_uri, 'total'=>$cont, 'code'=> $links]; 
    echo json_encode($respuestas);
