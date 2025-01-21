<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Curso Seleccionado</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
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

        .estado-select {
            min-width: 150px;
        }

        .table {
            background-color: #2C3E50;
            color: #ffffff;
            text-transform: uppercase;
        }

        .table th {
            background-color: #34495E;
            color: #ECF0F1;
        }

        .table td {
            background-color: #3E4A59;
            color: #ECF0F1;
        }

        .table td form .estado-select {
            background-color: #3E4A59;
            color: #ffffff;
        }

        .table td form .btn {
            background-color: #1ABC9C;
            color: #ffffff;
        }

        .table td form .btn:hover {
            background-color: #16A085;
        }

        .error-message {
            color: #e74c3c;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body style="background-color: #1E2A38; color: #ffffff;">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="background-color: #000; color: #fff; min-width: 250px;">
            <h3 class="text-center">EduFile</h3>
            <nav class="nav flex-column">
                <a href="index.php" class="nav-link text-white">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
                <div>
                    <a class="nav-link text-white" data-bs-toggle="collapse" href="#nivelMenu" role="button" aria-expanded="false" aria-controls="nivelMenu">
                        <i class="bi bi-box"></i> Niveles
                    </a>
                    <div class="collapse ms-3" id="nivelMenu">
                        <a href="inicialCursos.php" class="nav-link text-white"><i class="bi bi-circle"></i> Inicial</a>
                        <a href="primariaCursos.php" class="nav-link text-white"><i class="bi bi-circle"></i> Primaria</a>
                        <a href="secundariaCursos.php" class="nav-link text-white"><i class="bi bi-circle"></i> Secundaria</a>
                    </div>
                </div>
                <div>
                    <a class="nav-link text-white" href="estudiantes.php">
                        <i class="bi bi-people"></i> Estudiantes
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4">
            <?php
            include 'conexion.php';

            $grade = strtoupper(isset($_GET['grade']) ? $_GET['grade'] : '');
            $parallel = strtoupper(isset($_GET['parallel']) ? $_GET['parallel'] : '');
            $level = isset($_GET['level']) ? $_GET['level'] : '';

            if (empty($grade) || empty($parallel) || empty($level)) {
                echo "<div class='error-message'>Error: Faltan datos en la URL.</div>";
                exit;
            }

            $levelQuery = "SELECT levels.name AS level_name FROM levels WHERE levels.name = ? LIMIT 1";
            $stmt = $conn->prepare($levelQuery);
            $stmt->bind_param("s", $level);
            $stmt->execute();
            $levelResult = $stmt->get_result();

            if ($levelResult && $levelResult->num_rows > 0) {
                $levelData = $levelResult->fetch_assoc();
                $levelName = strtoupper($levelData['level_name']);
            } else {
                echo "<div class='error-message'>Error: Curso no encontrado para este nivel.</div>";
                exit;
            }

            echo "<h2 class='mb-4'>NIVEL: $levelName</h2>";
            echo "<h3 class='mb-4'>CURSO: $grade \"$parallel\"</h3>";

            $query = "SELECT s.id, UPPER(CONCAT(s.last_name_father, ' ', s.last_name_mother, ' ', s.first_name)) AS nombre, UPPER(s.rude_number) AS rude_number, sc.status
                      FROM students s
                      INNER JOIN student_courses sc ON s.id = sc.student_id
                      INNER JOIN courses c ON sc.course_id = c.id
                      WHERE c.grade = ? AND c.parallel = ? AND c.level_id = (SELECT id FROM levels WHERE name = ?)
                      ORDER BY FIELD(sc.status, 'Efectivo - I', 'No Inscrito') DESC, s.last_name_father ASC, s.last_name_mother ASC, s.first_name ASC";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $grade, $parallel, $level);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <div class="action-buttons">
                <div class="search-container">
                    <input type="text" id="searchStudent" class="form-control" placeholder="Buscar estudiante...">
                    <button class="btn btn-light" id="clearSearch" title="Borrar búsqueda">&times;</button>
                </div>
                <div>
                    <a href="vistaPDF.php?grade=<?php echo urlencode($grade); ?>&parallel=<?php echo urlencode($parallel); ?>&level=<?php echo urlencode($level); ?>" class="btn btn-secondary" target="_blank">Vista PDF</a>
                    <a href="nuevoEstudiante.php?grade=<?php echo $grade; ?>&parallel=<?php echo $parallel; ?>" class="btn btn-success">Nuevo Estudiante</a>
                </div>
            </div>

            <table class="table table-bordered" id="studentsTable">
                <thead>
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
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['rude_number']) . "</td>
                                    <td>
                                        <form class='estado-form d-flex align-items-center' data-student-id='" . htmlspecialchars($row['id']) . "' data-grade='$grade' data-parallel='$parallel'>
                                            <select name='estado' class='form-select form-select-sm estado-select me-2' style='background-color: $estado_color; color: white;'>
                                                <option value='Efectivo - I'" . ($row['status'] == 'Efectivo - I' ? ' selected' : '') . ">Efectivo - I</option>
                                                <option value='No Inscrito'" . ($row['status'] == 'No Inscrito' ? ' selected' : '') . ">No Inscrito</option>
                                            </select>
                                            <button type='button' class='btn btn-sm estado-guardar'>Guardar</button>
                                        </form>
                                    </td>
                                    <td><a href='editarEstudiante.php?student_id=" . htmlspecialchars($row['rude_number']) . "&grade=$grade&parallel=$parallel' class='btn btn-primary btn-sm'>Editar</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>NO HAY ESTUDIANTES DISPONIBLES</td></tr>";
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
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                student_id: studentId,
                                estado,
                                grade,
                                parallel
                            })
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

            searchInput.addEventListener('input', function() {
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

            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                for (let i = 1; i < rows.length; i++) {
                    rows[i].style.display = '';
                }
            });
        });
    </script>
</body>

</html>