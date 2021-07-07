<?php
$ruta="./Documentos/";
$archivo = $_GET['arch'];
// Se comprueba que realmente sea la ruta de un directorio
    if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
        $gestor = opendir($ruta);
        echo "<ul>";                
        $ruta_completa = $ruta . "/" . $archivo;
        // Se muestran todos los archivos y carpetas excepto "." y ".."
        if ($archivo != "." && $archivo != "..") {
            $img="./img/layout2.jpg";
        // Si es un directorio se recorre recursivamente
            if (is_dir($ruta_completa)) {
                echo '<button class="btn upload" style="background-image:url('.$img.')"><a href="https://jcamp.cl/ciencias/descarga.php?nombre='. $archivo . '">'. $archivo . '</a></button></br>';
                obtener_estructura_directorios($ruta_completa);
            } else {
                echo '<button class="btn upload" style="background-image:url('.$img.')"><a href="https://jcamp.cl/ciencias/descarga.php?nombre='. $archivo . '">'. $archivo . '</a></button></br>';
            }
        }
        // Cierra el gestor de directorios
        closedir($gestor);
        echo "</ul>";
    } else {
        echo "No es una ruta de directorio valida<br/>";
    }
    ?>