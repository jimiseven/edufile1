<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFile - Inicial Cursos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Estilos Personalizados -->
    <style>
        body {
            background-color: #1E2A38; /* Fondo oscuro original */
            color: #ffffff;
        }

        .sidebar {
            background-color: #000; /* Fondo del sidebar original */
            color: #fff;
            min-width: 250px;
            min-height: 100vh;
        }

        .sidebar .nav-link,
        .sidebar .nav-link:hover {
            color: #fff;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .course-card {
            background-color: #2C3E50; /* Color original de las tarjetas */
            border: 1px solid #1F618D;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .course-title {
            font-size: 1.25rem;
            margin-bottom: 5px;
            color: #1ABC9C; /* Color original para títulos */
            font-weight: bold;
            text-align: center;
        }

        .stat-badge {
            font-size: 0.85rem;
            padding: 5px 8px;
            border-radius: 15px;
            margin-right: 5px;
            margin-bottom: 5px;
            color: #ffffff;
        }

        .badge-total {
            background-color: #34495E; /* Gris oscuro */
        }

        .badge-efectivos {
            background-color: #27AE60; /* Verde para efectivos */
        }

        .badge-noinscritos {
            background-color: #C0392B; /* Rojo para no inscritos */
        }

        .progress {
            height: 8px;
            background-color: #34495E; /* Gris oscuro */
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-bar {
            background-color: #1ABC9C; /* Color para la barra de progreso */
        }

        .btn-view {
            background-color: #1F618D; /* Azul original para botones */
            border: none;
            width: 100%;
            font-weight: bold;
            color: #ffffff;
        }

        .btn-view:hover {
            background-color: #1A5276;
        }

        .porcentaje-efectivos {
            color: #ffffff; /* Color blanco para el texto del porcentaje */
            font-weight: bold;
        }

        .nav-link.active {
            background-color: #1F618D;
            color: #ffffff !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-width: 100%;
                min-height: auto;
            }

            .main-content {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="text-center">EduFile</h3>
            <nav class="nav flex-column">
                <a href="index.php" class="nav-link">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
                <div>
                    <a class="nav-link" data-bs-toggle="collapse" href="#nivelMenu" role="button" aria-expanded="false"
                        aria-controls="nivelMenu">
                        <i class="bi bi-box"></i> Niveles
                    </a>
                    <div class="collapse ms-3 show" id="nivelMenu">
                        <a href="inicialCursos.php" class="nav-link active"><i class="bi bi-circle"></i> Inicial</a>
                        <a href="primariaCursos.php" class="nav-link"><i class="bi bi-circle"></i> Primaria</a>
                        <a href="secundariaCursos.php" class="nav-link"><i class="bi bi-circle"></i> Secundaria</a>
                    </div>
                </div>
                <a class="nav-link" href="estudiantes.php">
                    <i class="bi bi-people"></i> Estudiantes
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2 class="mb-4">Nivel Inicial - Cursos</h2>
            <div class="row">
                <?php
                // Incluir el archivo de conexión
                include 'conexion.php';

                // Consultar cursos del nivel inicial
                $query = "SELECT id, grade, parallel FROM courses WHERE level_id = 1 ORDER BY grade, parallel";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($course = $result->fetch_assoc()) {
                        $course_id = $course['id'];
                        $grade = $course['grade'];
                        $parallel = $course['parallel'];

                        // Consultar estadísticas para este curso
                        $statsQuery = "SELECT 
                            COUNT(DISTINCT sc.student_id) AS total_registrados,
                            IFNULL(SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END), 0) AS total_efectivos,
                            IFNULL(SUM(CASE WHEN sc.status = 'No Inscrito' THEN 1 ELSE 0 END), 0) AS total_no_inscritos
                        FROM student_courses sc
                        WHERE sc.course_id = '$course_id'";

                        $statsResult = $conn->query($statsQuery);
                        $stats = $statsResult->fetch_assoc();

                        // Calcular porcentaje de efectivos
                        $porcentajeEfectivos = ($stats['total_registrados'] > 0) ? ($stats['total_efectivos'] / $stats['total_registrados']) * 100 : 0;

                        // Mostrar la tarjeta del curso
                        echo '<div class="col-md-6 col-lg-4">';
                        echo '<div class="card course-card">';
                        echo '<div class="card-body p-3">';
                        echo '<div class="course-title">Curso: ' . htmlspecialchars($grade) . ' - ' . htmlspecialchars($parallel) . '</div>';
                        echo '<div class="mb-2">';
                        echo '<span class="stat-badge badge-total">Total: ' . $stats['total_registrados'] . '</span>';
                        echo '<span class="stat-badge badge-efectivos">Efectivos: ' . $stats['total_efectivos'] . '</span>';
                        echo '<span class="stat-badge badge-noinscritos">No Inscritos: ' . $stats['total_no_inscritos'] . '</span>';
                        echo '</div>';
                        echo '<div class="progress mb-2">';
                        echo '<div class="progress-bar" role="progressbar" style="width: ' . $porcentajeEfectivos . '%;" aria-valuenow="' . $porcentajeEfectivos . '" aria-valuemin="0" aria-valuemax="100"></div>';
                        echo '</div>';
                        echo '<small class="porcentaje-efectivos">Porcentaje de Efectivos: ' . number_format($porcentajeEfectivos, 2) . '%</small>';
                        echo '<a href="vistaGenCurso.php?grade=' . urlencode($grade) . '&parallel=' . urlencode($parallel) . '&level=inicial" class="btn btn-view btn-sm mt-2">Ver Detalles <i class="bi bi-eye"></i></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No se encontraron cursos en el nivel inicial.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
