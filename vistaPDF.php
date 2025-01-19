<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
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

    $grade = isset($_GET['grade']) ? $_GET['grade'] : '';
    $parallel = isset($_GET['parallel']) ? $_GET['parallel'] : '';

    // Obtener nivel del curso
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

    // Obtener estudiantes con estado "Efectivo - I"
    $query = "SELECT s.last_name_father, s.last_name_mother, s.first_name
              FROM students s
              INNER JOIN student_courses sc ON s.id = sc.student_id
              INNER JOIN courses c ON sc.course_id = c.id
              WHERE c.grade = ? AND c.parallel = ? AND sc.status = 'Efectivo - I'
              ORDER BY
                s.last_name_father ASC,
                s.last_name_mother ASC,
                s.first_name ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $grade, $parallel);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!-- Botón de imprimir -->
    <a href="javascript:window.print();" class="btn btn-primary btn-print">Imprimir</a>

    <div class="header">
        <h1>U.E. Simón Bolívar</h1>
        <h2>Lista de Estudiantes</h2>
        <h2>Nivel: <?php echo htmlspecialchars($levelName); ?></h2>
        <h2>Curso: <?php echo htmlspecialchars($grade . ' "' . $parallel . '"'); ?></h2>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Nombre</th>
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
