<?php
require_once 'conection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el nombre del archivo PDF a eliminar
    $sql = "SELECT archivo_pdf FROM documentos WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $archivo_pdf = $row['archivo_pdf'];
    } else {
        die('Registro no encontrado');
    }

    // Eliminar el registro de la base de datos
    $sql = "DELETE FROM documentos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Eliminar el archivo PDF del servidor
        $ruta_archivo = "pdfs/". $archivo_pdf;
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }
        header("Location: index.php?status=delete");
        exit();
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

$conn->close();
