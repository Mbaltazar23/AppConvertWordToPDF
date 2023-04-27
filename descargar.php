<?php
require_once 'conection.php';

if (isset($_GET['archivo'])) {
    $archivo_pdf =  $_GET['archivo'];
    $ruta_archivo = 'pdfs/' .$archivo_pdf;

    // Verificar si el archivo existe en el servidor
    if (file_exists($ruta_archivo)) {
        // Establecer la cabecera HTTP para forzar la descarga del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($ruta_archivo) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($ruta_archivo));
        readfile($ruta_archivo);
        exit;
    } else {
        die('El archivo no existe');
    }
}
