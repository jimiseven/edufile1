<?php
include 'conexion.php';

// Consultas SQL (las mismas que en vista_impresion.php)
$queryGlobal = "SELECT 
                SUM(CASE WHEN gender = 'M' THEN 1 ELSE 0 END) AS hombres,
                SUM(CASE WHEN gender = 'F' THEN 1 ELSE 0 END) AS mujeres,
                SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS efectivos,
                SUM(CASE WHEN sc.status = 'No Inscrito' THEN 1 ELSE 0 END) AS no_inscritos
            FROM students s
            LEFT JOIN student_courses sc ON s.id = sc.student_id";
$resultGlobal = $conn->query($queryGlobal);
$globalData = $resultGlobal->fetch_assoc();

$queryByLevel = "SELECT 
                l.name AS level_name,
                SUM(CASE WHEN s.gender = 'M' THEN 1 ELSE 0 END) AS hombres,
                SUM(CASE WHEN s.gender = 'F' THEN 1 ELSE 0 END) AS mujeres,
                SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS efectivos,
                SUM(CASE WHEN sc.status = 'No Inscrito' THEN 1 ELSE 0 END) AS no_inscritos
            FROM students s
            INNER JOIN student_courses sc ON s.id = sc.student_id
            INNER JOIN courses c ON sc.course_id = c.id
            INNER JOIN levels l ON c.level_id = l.id
            GROUP BY l.name";
$resultByLevel = $conn->query($queryByLevel);

$queryByCourse = "SELECT 
                l.name AS level_name,
                CONCAT(c.grade, ' ', c.parallel) AS course_name,
                SUM(CASE WHEN s.gender = 'M' AND sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS hombres,
                SUM(CASE WHEN s.gender = 'F' AND sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS mujeres,
                SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS total
            FROM courses c
            INNER JOIN levels l ON c.level_id = l.id
            LEFT JOIN student_courses sc ON c.id = sc.course_id
            LEFT JOIN students s ON sc.student_id = s.id
            GROUP BY l.name, c.grade, c.parallel
            ORDER BY l.name, c.grade, c.parallel";
$resultByCourse = $conn->query($queryByCourse);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFile - Dashboard Estadístico</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1E2A38;
            color: #ffffff;
        }

        .sidebar {
            background-color: #000;
            min-width: 250px;
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .card-stat {
            background-color: #1F618D;
            color: #ffffff;
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .chart-container {
            background-color: #2C3E50;
            padding: 20px;
            border-radius: 15px;
            margin-top: 30px;
        }

        .table-custom {
            background-color: #2C3E50;
            color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-custom th {
            background-color: #1F618D;
            border-color: #1F618D;
        }

        .table-custom td, .table-custom th {
            border-color: #34495E;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <h2 class="mb-4">Dashboard Estadístico</h2>

            <!-- Totales Generales -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-stat">
                        <div class="card-header text-center">
                            <h4><i class="bi bi-people-fill"></i> Totales Generales</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center border-end">
                                    <h5>Hombres</h5>
                                    <p class="display-6"><?= $globalData['hombres'] ?></p>
                                </div>
                                <div class="col-md-3 text-center border-end">
                                    <h5>Mujeres</h5>
                                    <p class="display-6"><?= $globalData['mujeres'] ?></p>
                                </div>
                                <div class="col-md-3 text-center border-end">
                                    <h5>Efectivos</h5>
                                    <p class="display-6"><?= $globalData['efectivos'] ?></p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h5>No Inscritos</h5>
                                    <p class="display-6"><?= $globalData['no_inscritos'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas por Nivel -->
            <h3 class="mb-3"><i class="bi bi-layers"></i> Por Nivel Educativo</h3>
            <div class="row g-4 mb-4">
                <?php while($level = $resultByLevel->fetch_assoc()) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-stat">
                        <div class="card-header text-center">
                            <?= $level['level_name'] ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <h5><i class="bi bi-gender-male"></i> Hombres</h5>
                                    <p class="h4"><?= $level['hombres'] ?></p>
                                </div>
                                <div class="col-6">
                                    <h5><i class="bi bi-gender-female"></i> Mujeres</h5>
                                    <p class="h4"><?= $level['mujeres'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-6 border-end">
                                    <h5><i class="bi bi-check-circle"></i> Efectivos</h5>
                                    <p class="h4"><?= $level['efectivos'] ?></p>
                                </div>
                                <div class="col-6">
                                    <h5><i class="bi bi-x-circle"></i> No Inscritos</h5>
                                    <p class="h4"><?= $level['no_inscritos'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Estudiantes Efectivos por Curso -->
            <h3 class="mb-3"><i class="bi bi-book"></i> Efectivos por Curso</h3>
            <div class="chart-container">
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Nivel</th>
                                <th>Curso</th>
                                <th>Hombres</th>
                                <th>Mujeres</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($curso = $resultByCourse->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $curso['level_name'] ?></td>
                                <td><?= $curso['course_name'] ?></td>
                                <td><?= $curso['hombres'] ?></td>
                                <td><?= $curso['mujeres'] ?></td>
                                <td><?= $curso['total'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>