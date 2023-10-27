<?php
// Verifica que se haya enviado el formulario
if (isset($_POST['libro_id']) && isset($_POST['fecha_pedido']) && isset($_POST['fecha_devolucion'])) {
    // Obtener los valores del formulario
    $libro_id = $_POST['libro_id'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    // Obtener el nombre del estudiante de la sesión
    session_start();
    $nombreEstudiante = $_SESSION['login']; // Cambiar 'stdname' a 'login'

    // Conectar a la base de datos (reemplaza con tus propios detalles)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Comprobar la conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Verificar si ya existe un registro con el mismo libro_id y EmailId
    $check_query = "SELECT * FROM prestamos WHERE libro_id = '$libro_id' AND EmailId = '$nombreEstudiante'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // El registro ya existe, muestra un mensaje de error
        echo "Ya has solicitado este libro previamente.";
    } else {
        // Generar el PDF
        require('tcpdf/tcpdf.php');

        class PDF extends TCPDF {
            function Header() {
                // Encabezado del PDF (opcional)
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 10, 'Solicitud de Préstamo', 0, 1, 'C');
            }

            function Footer() {
                // Pie de página del PDF (opcional)
                $this->SetY(-15);
                $this->SetFont('helvetica', 'I', 8);
                $this->Cell(0, 10, 'Firma del Estudiante: ____________________________________', 0, 0, 'L');
                $this->Cell(0, 10, 'Firma del Administrador: ________________________________', 0, 0, 'R');
            }
        }

        // Crear el objeto PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetY(5);
        $pdf->SetX(10);

        // Obtener información del libro
        $get_libro_query = "SELECT * FROM libros WHERE id = '$libro_id'";
        $result = mysqli_query($conn, $get_libro_query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Mostrar información del libro en el PDF
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Image("uts.jpg", 5, 5, 40, 20, 'JPG');
            $pdf->Image("logo.jpg", 150, 5, 40, 20, 'JPG');
            // Agregar contenido al PDF
            $pdf->SetY(25);
            $pdf->Cell(0, 10, 'Correo del estudiante: ' . $nombreEstudiante, 0, 1);
            $pdf->Cell(0, 10, 'Nombre del libro: ' . $row['nombre'], 0, 1);
            $pdf->Cell(0, 10, 'Autor: ' . $row['autor'], 0, 1);
            $pdf->Cell(0, 10, 'Editorial: ' . $row['editorial'], 0, 1);
            $pdf->Cell(0, 10, 'ISBN: ' . $row['isbn'], 0, 1);
            $pdf->Cell(0, 10, 'Colocación: ' . $row['colocación'] . ' ' . $row['num'], 0, 1);
            $pdf->Cell(0, 10, 'Edición: ' . $row['edición'], 0, 1);
            $pdf->Cell(0, 10, 'Estado: ' . $row['estado'], 0, 1);
            
        } else {
            // Mensaje de error si no se encuentra el libro
            $pdf->Cell(0, 10, 'Error: No se pudo obtener la información del libro.', 0, 1);
        }

        // Salida del PDF
        $pdf->Output('solicitud_prestamo.pdf', 'I'); // Mostrar el PDF en el navegador

        // Insertar la información en la tabla "prestamos"
        $insert_prestamo_query = "INSERT INTO prestamos (libro_id, EmailId, fecha_pedido, fecha_devolucion) VALUES ('$libro_id', '$nombreEstudiante', '$fecha_pedido', '$fecha_devolucion')";

        if (mysqli_query($conn, $insert_prestamo_query)) {
            // La información del préstamo se guardó correctamente en la tabla "prestamos"
            // Aquí puedes agregar un mensaje adicional si lo deseas
        } else {
            // Hubo un error al guardar la información del préstamo
            echo "Error al enviar la solicitud: " . mysqli_error($conn);
        }
    }

    // Cerrar la conexión
    mysqli_close($conn);
} else {
    echo "Faltan datos para procesar la solicitud.";
}
?>
