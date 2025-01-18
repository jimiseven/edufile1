<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFile - Primaria Cursos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color: #1E2A38; color: #ffffff;">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="background-color: #283848; color: #ffffff;">
            <h3 class="text-center">EduFile</h3>
            <nav class="nav flex-column">
                <a href="#" class="nav-link text-white">Cursos</a>
                <a href="inicialCursos.php" class="nav-link text-white">Inicial</a>
                <a href="primariaCursos.php" class="nav-link text-white">Primaria</a>
                <a href="secundariaCursos.php" class="nav-link text-white">Secundaria</a>
                <a href="#" class="nav-link text-white">Estudiantes</a>
                <a href="#" class="nav-link text-white">Profesores</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4" style="background-color: #1E2A38; color: #ffffff;">
            <h2 class="mb-4">Nivel Primaria</h2>
            <table class="table table-bordered">
                <thead style="background-color: #1F618D; color: #ffffff;">
                    <tr>
                        <th>CURSO</th>
                        <th>PARALELO</th>
                        <th>ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo de conexión
                    include 'conexion.php';

                    // Consultar cursos del nivel primaria
                    $query = "SELECT grade, parallel FROM courses WHERE level_id = 2"; // Nivel primaria (level_id = 2)
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr style='background-color: #2874A6; color: #ffffff;'>
                                    <td>" . htmlspecialchars($row['grade']) . "</td>
                                    <td>" . htmlspecialchars($row['parallel']) . "</td>
                                    <td><a href='vistaGenCurso.php?grade=" . $row['grade'] . "&parallel=" . $row['parallel'] . "' class='btn btn-primary btn-sm' style='background-color: #28B463; border-color: #28B463;'>Ver</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center' style='background-color: #2874A6; color: #ffffff;'>No hay cursos disponibles</td></tr>";
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
