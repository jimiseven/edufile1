<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Curso Seleccionado</title>
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
        <div class="main-content flex-grow-1 p-4">
            <?php
            // Incluir el archivo de conexión
            include 'conexion.php';

            // Obtener datos del curso seleccionado
            $grade = isset($_GET['grade']) ? $_GET['grade'] : '';
            $parallel = isset($_GET['parallel']) ? $_GET['parallel'] : '';

            // Consultar nivel dinámico
            $levelQuery = "SELECT levels.name AS level_name
                           FROM levels
                           INNER JOIN courses ON levels.id = courses.level_id
                           WHERE courses.grade = ? AND courses.parallel = ? LIMIT 1";
            $stmt = $conn->prepare($levelQuery);
            $stmt->bind_param("ss", $grade, $parallel);
            $stmt->execute();
            $levelResult = $stmt->get_result();

            if ($levelResult && $levelResult->num_rows > 0) {
                $levelData = $levelResult->fetch_assoc();
                $levelName = $levelData['level_name'];
            } else {
                $levelName = 'Nivel Desconocido';
            }

            echo "<h2 class='mb-4'>Nivel: $levelName</h2>";
            echo "<h3 class='mb-4'>Curso $grade \"$parallel\"</h3>";

            // Consultar estudiantes del curso seleccionado
            $query = "SELECT CONCAT(last_name_father, ' ', last_name_mother, ' ', first_name) AS nombre,
                             rude_number, status
                      FROM students
                      INNER JOIN student_courses ON students.id = student_courses.student_id
                      INNER JOIN courses ON student_courses.course_id = courses.id
                      WHERE courses.grade = ? AND courses.parallel = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $grade, $parallel);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary" onclick="window.history.back();">Atrás</button>
                <button class="btn btn-secondary">PDF Lista</button>
            </div>

            <table class="table table-bordered">
                <thead style="background-color: #1F618D; color: #ffffff;">
                    <tr>
                        <th>Nombre</th>
                        <th>Rude</th>
                        <th>Estado</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $estado_color = match ($row['status']) {
                                'Efectivo - I' => '#28a745',
                                'Efectivo - T' => '#28a745',
                                'Traslado' => '#007bff',
                                'Retirado' => '#17a2b8',
                                'No Inscrito' => '#dc3545',
                                default => '#6c757d',
                            };
                            echo "<tr style='background-color: #34495E; color: #ffffff;'>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['rude_number']) . "</td>
                                    <td>
                                        <form method='POST' action='cambiarEstado.php' style='display:inline;'>
                                            <select name='estado' class='form-select form-select-sm' style='width: auto; background-color: $estado_color; color: white;'>
                                                <option value='Efectivo - I'" . ($row['status'] == 'Efectivo - I' ? ' selected' : '') . ">Efectivo - I</option>
                                                <option value='Efectivo - T'" . ($row['status'] == 'Efectivo - T' ? ' selected' : '') . ">Efectivo - T</option>
                                                <option value='Traslado'" . ($row['status'] == 'Traslado' ? ' selected' : '') . ">Traslado</option>
                                                <option value='Retirado'" . ($row['status'] == 'Retirado' ? ' selected' : '') . ">Retirado</option>
                                                <option value='No Inscrito'" . ($row['status'] == 'No Inscrito' ? ' selected' : '') . ">No Inscrito</option>
                                            </select>
                                            <button type='submit' class='btn btn-sm' style='background-color: $estado_color; color: white;'>Guardar</button>
                                            <input type='hidden' name='student_id' value='" . htmlspecialchars($row['rude_number']) . "'>
                                        </form>
                                    </td>
                                    <td><button class='btn btn-primary btn-sm'>Editar</button></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center' style='background-color: #34495E; color: #ffffff;'>No hay estudiantes disponibles</td></tr>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>

            <div class="text-end">
                <button class="btn btn-success">Nuevo Estudiante</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
