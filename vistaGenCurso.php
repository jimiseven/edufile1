<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Curso Seleccionado</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-container input {
            margin-right: 10px;
        }
    </style>
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
            include 'conexion.php';

            $grade = isset($_GET['grade']) ? $_GET['grade'] : '';
            $parallel = isset($_GET['parallel']) ? $_GET['parallel'] : '';

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

            $query = "SELECT s.id, CONCAT(s.last_name_father, ' ', s.last_name_mother, ' ', s.first_name) AS nombre,
                             s.rude_number, sc.status
                      FROM students s
                      INNER JOIN student_courses sc ON s.id = sc.student_id
                      INNER JOIN courses c ON sc.course_id = c.id
                      WHERE c.grade = ? AND c.parallel = ?
                      ORDER BY
                        FIELD(sc.status, 'Efectivo - I', 'No Inscrito') DESC,
                        CASE WHEN s.last_name_father IS NULL OR s.last_name_father = '' THEN 0 ELSE 1 END ASC,
                        s.last_name_father ASC,
                        s.last_name_mother ASC,
                        s.first_name ASC";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $grade, $parallel);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <div class="action-buttons">
                <div class="search-container">
                    <input type="text" id="searchStudent" class="form-control" placeholder="Buscar estudiante...">
                    <button class="btn btn-light" id="clearSearch" title="Borrar búsqueda">&times;</button>
                </div>
                <div>
                    <a href="vistaPDF.php?grade=<?php echo urlencode($grade); ?>&parallel=<?php echo urlencode($parallel); ?>" class="btn btn-secondary" target="_blank">Vista PDF</a>
                    <a href="nuevoEstudiante.php?grade=<?php echo $grade; ?>&parallel=<?php echo $parallel; ?>" class="btn btn-success">Nuevo Estudiante</a>
                </div>
            </div>

            <table class="table table-bordered" id="studentsTable">
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
                                'No Inscrito' => '#dc3545',
                                default => '#6c757d',
                            };
                            echo "<tr style='background-color: #34495E; color: #ffffff;'>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['rude_number']) . "</td>
                                    <td>
                                        <form class='estado-form' data-student-id='" . htmlspecialchars($row['id']) . "' data-grade='$grade' data-parallel='$parallel'>
                                            <select name='estado' class='form-select form-select-sm estado-select' style='width: auto; background-color: $estado_color; color: white;'>
                                                <option value='Efectivo - I'" . ($row['status'] == 'Efectivo - I' ? ' selected' : '') . ">Efectivo - I</option>
                                                <option value='No Inscrito'" . ($row['status'] == 'No Inscrito' ? ' selected' : '') . ">No Inscrito</option>
                                            </select>
                                            <button type='button' class='btn btn-sm estado-guardar' style='background-color: $estado_color; color: white;'>Guardar</button>
                                        </form>
                                    </td>
                                    <td><a href='editarEstudiante.php?student_id=" . htmlspecialchars($row['rude_number']) . "&grade=$grade&parallel=$parallel' class='btn btn-primary btn-sm'>Editar</a></td>
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
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('.estado-form');
            const searchInput = document.getElementById('searchStudent');
            const clearButton = document.getElementById('clearSearch');
            const table = document.getElementById('studentsTable');
            const rows = table.getElementsByTagName('tr');

            forms.forEach(form => {
                const select = form.querySelector('.estado-select');
                const button = form.querySelector('.estado-guardar');

                button.addEventListener('click', () => {
                    const studentId = form.dataset.studentId;
                    const grade = form.dataset.grade;
                    const parallel = form.dataset.parallel;
                    const estado = select.value;

                    fetch('cambiarEstado.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({ student_id: studentId, estado, grade, parallel })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const newColor = data.color;
                            select.style.backgroundColor = newColor;
                            button.style.backgroundColor = newColor;
                            alert('Estado actualizado correctamente.');
                        } else {
                            alert('Error al actualizar el estado: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error al intentar actualizar el estado.');
                    });
                });
            });

            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    const studentName = cells[0]?.textContent.toLowerCase() || '';
                    const studentRude = cells[1]?.textContent.toLowerCase() || '';

                    if (studentName.includes(searchValue) || studentRude.includes(searchValue)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            clearButton.addEventListener('click', function () {
                searchInput.value = '';
                for (let i = 1; i < rows.length; i++) {
                    rows[i].style.display = '';
                }
            });
        });
    </script>
</body>

</html>
