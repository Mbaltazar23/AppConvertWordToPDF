<?php

require_once 'vendor/autoload.php';
require_once 'conection.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

Settings::setPdfRendererPath('vendor/tecnickcom/tcpdf');
Settings::setPdfRendererName('TCPDF');

if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_FILES['archivo_word']) && $_FILES['archivo_word']['error'] === UPLOAD_ERR_OK) {
    $nombre_archivo = $_FILES['archivo_word']['name'];
    $archivo_tmp = $_FILES['archivo_word']['tmp_name'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    // Comprobar la extensión del archivo
    $extension_archivo = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
    if ($extension_archivo !== 'docx' && $extension_archivo !== 'doc') {
        die('El archivo debe ser un documento de Word (.docx o .doc)');
    }

    // Validar que el nombre de archivo no se repita
    $sql = "SELECT * FROM documentos WHERE archivo_word='$nombre_archivo'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        header("Location: index.php?status=duplicate");
        exit();
    }

    // Crear un nuevo objeto PhpWord
    $phpWord = new PhpWord();

    // Agregar los datos recuperados a un nuevo documento
    $section = $phpWord->addSection();
    $section->addText('Nombre: ' . $nombre);
    $section->addText('Email: ' . $email);

    // Crear el escritor de PDF y guardar el archivo PDF generado
    $writer = IOFactory::createWriter($phpWord, 'PDF');
    $archivo_pdf = str_replace('.docx', '.pdf', $nombre_archivo);
    $archivo_pdf = str_replace('.doc', '.pdf', $archivo_pdf);
    $ruta_archivo_pdf = 'pdfs/' . $archivo_pdf; // ruta donde se guardará el archivo PDF
    $writer->save($ruta_archivo_pdf); // guardar el archivo PDF en la ruta especificada

    // Guardar el registro en la base de datos
    $sql = "INSERT INTO documentos (nombre, email, archivo_word, archivo_pdf) VALUES ('$nombre', '$email', '$nombre_archivo', '$archivo_pdf')";
    if ($conn->query($sql) === true) {
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
