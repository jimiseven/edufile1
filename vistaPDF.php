<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes</title>
    <!-- Incluye tus enlaces a CSS y otros elementos del head aquí -->
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 18px;
            margin: 5px 0;
        }

        .btn-print {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .table-container {
            margin: 0 auto;
            width: 90%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }

        .table th {
            background-color: #1F618D;
            color: #ffffff;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php
    include 'conexion.php';

    // Obtener parámetros desde la URL
    $grade = isset($_GET['grade']) ? $_GET['grade'] : '';
    $parallel = isset($_GET['parallel']) ? $_GET['parallel'] : '';
    $levelName = isset($_GET['level']) ? $_GET['level'] : '';

    // Verificar que los parámetros sean válidos
    if (empty($grade) || empty($parallel) || empty($levelName)) {
        echo "<div class='alert alert-danger'>Parámetros de curso no válidos.</div>";
        exit;
    }

    // Obtener level_id basado en el nombre del nivel
    $levelQuery = "SELECT id FROM levels WHERE name = ?";
    $stmt = $conn->prepare($levelQuery);
    $stmt->bind_param("s", $levelName);
    $stmt->execute();
    $levelResult = $stmt->get_result();

    if ($levelResult && $levelResult->num_rows > 0) {
        $levelData = $levelResult->fetch_assoc();
        $levelId = $levelData['id'];
    } else {
        echo "<div class='alert alert-danger'>Nivel no válido.</div>";
        exit;
    }

    // Obtener course_id basado en grade, parallel y level_id
    $courseQuery = "SELECT id FROM courses WHERE grade = ? AND parallel = ? AND level_id = ?";
    $stmt = $conn->prepare($courseQuery);
    $stmt->bind_param("ssi", $grade, $parallel, $levelId);
    $stmt->execute();
    $courseResult = $stmt->get_result();

    if ($courseResult && $courseResult->num_rows > 0) {
        $courseData = $courseResult->fetch_assoc();
        $courseId = $courseData['id'];
    } else {
        echo "<div class='alert alert-danger'>Curso no válido.</div>";
        exit;
    }

    // Obtener estudiantes con estado "Efectivo - I" para el curso específico
    $query = "SELECT UPPER(s.last_name_father) AS last_name_father,
                     UPPER(s.last_name_mother) AS last_name_mother,
                     UPPER(s.first_name) AS first_name
              FROM students s
              INNER JOIN student_courses sc ON s.id = sc.student_id
              WHERE sc.course_id = ? AND sc.status = 'Efectivo - I'
              ORDER BY
                s.last_name_father ASC,
                s.last_name_mother ASC,
                s.first_name ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!-- Botón de imprimir -->
    <a href="javascript:window.print();" class="btn btn-primary btn-print">Imprimir</a>

    <div class="header">
        <h1>U.E. SIMÓN BOLÍVAR</h1>
        <h2>LISTA DE ESTUDIANTES</h2>
        <h2>NIVEL: <?php echo htmlspecialchars($levelName); ?></h2>
        <h2>CURSO: <?php echo htmlspecialchars($grade . ' "' . $parallel . '"'); ?></h2>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>APELLIDO PATERNO</th>
                    <th>APELLIDO MATERNO</th>
                    <th>NOMBRE</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                $maxRows = 27;

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$index}</td>
                                <td>" . htmlspecialchars($row['last_name_father']) . "</td>
                                <td>" . htmlspecialchars($row['last_name_mother']) . "</td>
                                <td>" . htmlspecialchars($row['first_name']) . "</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='9'>No se encontraron estudiantes con el estado 'Efectivo - I' para este curso.</td></tr>";
                }

                // Agregar filas vacías si no se alcanzan las 27
                for ($i = $index; $i <= $maxRows; $i++) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>