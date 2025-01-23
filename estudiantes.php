<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        .table {
            background-color: #2C3E50;
            color: #ffffff;
        }

        .table th {
            background-color: #34495E;
            color: #ECF0F1;
        }

        .table td {
            background-color: #3E4A59;
            color: #ECF0F1;
        }

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

        .btn-clear {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-clear:hover {
            background-color: #c82333;
        }

        .btn-new-student {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-new-student:hover {
            background-color: #218838;
        }
    </style>
</head>

<body style="background-color: #1E2A38; color: #ffffff;">
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4">
            <h2 class="mb-4">Lista de Estudiantes</h2>

            <div class="action-buttons">
                <div class="search-container">
                    <input type="text" id="searchStudent" class="form-control" placeholder="Buscar estudiante...">
                    <button class="btn btn-clear" id="clearSearch">&times;</button>
                </div>
                <div class="d-flex flex-column">
                    <a href="cambioCurso.php" class="btn btn-danger mb-2">Cambio Curso</a>
                    <a href="nuevoRegistroEstudiante.php" class="btn btn-new-student">Nuevo Estudiante</a>
                </div>
            </div>


            <table class="table table-bordered" id="studentsTable">
                <thead>
                    <tr>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>Nivel</th>
                        <th>Curso</th>
                        <th>Paralelo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir conexión a la base de datos
                    include 'conexion.php';

                    $query = "
                        SELECT s.last_name_father, s.last_name_mother, s.first_name, l.name AS level_name, c.grade, c.parallel, s.rude_number
                        FROM students s
                        INNER JOIN student_courses sc ON s.id = sc.student_id
                        INNER JOIN courses c ON sc.course_id = c.id
                        INNER JOIN levels l ON c.level_id = l.id
                        ORDER BY s.last_name_father ASC, s.last_name_mother ASC, s.first_name ASC
                    ";

                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['last_name_father']) . "</td>
                                <td>" . htmlspecialchars($row['last_name_mother']) . "</td>
                                <td>" . htmlspecialchars($row['first_name']) . "</td>
                                <td>" . htmlspecialchars($row['level_name']) . "</td>
                                <td>" . htmlspecialchars($row['grade']) . "</td>
                                <td>" . htmlspecialchars($row['parallel']) . "</td>
                                <td>
                                    <a href='editarEstudiante.php?student_id=" . urlencode($row['rude_number']) . "&grade=" . urlencode($row['grade']) . "&parallel=" . urlencode($row['parallel']) . "' class='btn btn-primary btn-sm'>Editar</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No hay estudiantes disponibles</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchStudent');
            const clearButton = document.getElementById('clearSearch');
            const table = document.getElementById('studentsTable');
            const rows = table.getElementsByTagName('tr');

            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent.toLowerCase();
                        if (cellText.includes(searchValue)) {
                            found = true;
                            break;
                        }
                    }

                    rows[i].style.display = found ? '' : 'none';
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

    <!-- Pop-up de confirmación -->
    <div id="alertPopup" class="alert-popup">Estudiante eliminado correctamente.</div>

    <script>
        // Mostrar el pop-up si se pasa el estado 'deleted' en la URL
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status') && urlParams.get('status') === 'deleted') {
                const alertPopup = document.getElementById('alertPopup');
                alertPopup.classList.add('show');

                // Ocultar el pop-up después de 1 segundo
                setTimeout(() => {
                    alertPopup.classList.remove('show');
                }, 1500);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status') && urlParams.get('status') === 'updated') {
                const alertPopup = document.createElement('div');
                alertPopup.className = 'alert-popup show';
                alertPopup.textContent = 'Datos del estudiante actualizados correctamente';
                document.body.appendChild(alertPopup);

                setTimeout(() => {
                    alertPopup.remove();
                }, 1500);
            }
        });
    </script>


    <style>
        .alert-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            padding: 15px 20px;
            background-color: #dc3545;
            /* Rojo de Bootstrap */
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .alert-popup.show {
            opacity: 1;
            visibility: visible;
        }
    </style>

</body>

</html>