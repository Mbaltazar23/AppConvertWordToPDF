<?php
$msg = "";
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $msg .= "<p>El archivo Word se ha convertido correctamente a PDF y se ha guardado en la carpeta 'pdfs'.</p>";
}else if(isset($_GET['status']) && $_GET['status'] === 'duplicate') {
    $msg .= "<p style='color: yellow;'>El archivo Word ya ha sido convertido anteriormente.</p>";
}else if(isset($_GET['status']) && $_GET['status'] === 'delete'){
    $msg .= "<p style='color: red;'>El archivo Word ya ha sido convertido anteriormente.</p>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear y Convertir Word a PDF</title>
    <link rel="shortcut icon" href="icon/icono_pdf.png">
</head>
<body>
    <h1>Crear y Convertir Word a PDF</h1>
    <form action="convertir.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
        <label for="archivo_word">Documento de Word:</label>
        <input type="file" id="archivo_word" name="archivo_word"><br><br>
        <input type="submit" value="Convertir a PDF">
    </form>
    <br><br>
    <h2>Listado de documentos convertidos:</h2>
	<table border="1">
        <tr>
            <th>Número</th>
            <th>Nombre del archivo Word</th>
            <th>Nombre del archivo PDF</th>
            <th>Acciones</th>
        </tr>
        <?php

			require_once 'conection.php';

			// Consultar los documentos convertidos
			$sql = "SELECT * FROM documentos";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// Mostrar la lista de documentos
				$numero = 1;
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $numero . "</td>";
					echo "<td>" . $row['archivo_word'] . "</td>";
					echo "<td><a href='descargar.php?archivo=" . $row['archivo_pdf'] . "'>" . $row['archivo_pdf'] . "</a></td>";
					echo "<td><a href='eliminar.php?id=" . $row['Id'] . "'>Eliminar</a></td>";
					echo "</tr>";
					$numero++;
				}
			} else {
				echo "<tr><td colspan='4'>No hay documentos convertidos.</td></tr>";
			}

			// Cerrar la conexión a la base de datos
			$conn->close();
			?>
    </table>
	<?=$msg?>
</body>
</html>
