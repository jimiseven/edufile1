<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFile - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .stat-card {
            background-color: #1F618D;
            color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        .stat-card p {
            font-size: 1.2rem;
            margin: 10px 0 0;
        }

        .chart-container {
            background-color: #2C3E50;
            padding: 20px;
            border-radius: 10px;
            color: #ffffff;
        }

        .chart-title {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body style="background-color: #1E2A38; color: #ffffff;">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="background-color: #000; color: #fff; min-width: 250px;">
            <h3 class="text-center">EduFile</h3>
            <nav class="nav flex-column">
                <a href="#" class="nav-link text-white">
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
                    <a class="nav-link text-white" href="#">
                        <i class="bi bi-people"></i> Estudiantes
                    </a>
                </div>
                <div>
                    <a class="nav-link text-white" href="#">
                        <i class="bi bi-person"></i> Profesores
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4">
            <h2 class="mb-4">Dashboard - Estadísticas Generales</h2>

            <!-- Stat Cards -->
            <div class="row mb-4">
                <?php
                include 'conexion.php';

                // Consulta global para contar estudiantes
                $queryGlobal = "SELECT 
                                    SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS efectivos,
                                    SUM(CASE WHEN sc.status = 'No Inscrito' THEN 1 ELSE 0 END) AS no_inscritos
                                FROM student_courses sc";
                $resultGlobal = $conn->query($queryGlobal);
                $globalData = $resultGlobal->fetch_assoc();

                // Consultar estadísticas por nivel
                $queryByLevel = "SELECT 
                                    l.name AS level_name,
                                    SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS efectivos,
                                    SUM(CASE WHEN sc.status = 'No Inscrito' THEN 1 ELSE 0 END) AS no_inscritos
                                FROM student_courses sc
                                INNER JOIN courses c ON sc.course_id = c.id
                                INNER JOIN levels l ON c.level_id = l.id
                                GROUP BY l.name";
                $resultByLevel = $conn->query($queryByLevel);

                ?>

                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <h3>Total Efectivos</h3>
                        <p><?php echo $globalData['efectivos']; ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <h3>Total No Inscritos</h3>
                        <p><?php echo $globalData['no_inscritos']; ?></p>
                    </div>
                </div>

                <?php while ($level = $resultByLevel->fetch_assoc()) { ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card">
                            <h3><?php echo htmlspecialchars($level['level_name']); ?></h3>
                            <p>Efectivos: <?php echo $level['efectivos']; ?></p>
                            <p>No Inscritos: <?php echo $level['no_inscritos']; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Chart Section -->
            <div class="chart-container">
                <h3 class="chart-title">Estudiantes por Nivel</h3>
                <canvas id="chartNivel"></canvas>
            </div>

            <?php
            // Datos para el gráfico
            $chartData = [];
            $resultByLevel->data_seek(0); // Reset pointer
            while ($row = $resultByLevel->fetch_assoc()) {
                $chartData[] = [
                    'level' => $row['level_name'],
                    'efectivos' => $row['efectivos'],
                    'no_inscritos' => $row['no_inscritos']
                ];
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('chartNivel').getContext('2d');
            const data = <?php echo json_encode($chartData); ?>;

            const labels = data.map(item => item.level);
            const efectivos = data.map(item => item.efectivos);
            const noInscritos = data.map(item => item.no_inscritos);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Efectivos',
                            data: efectivos,
                            backgroundColor: '#1ABC9C'
                        },
                        {
                            label: 'No Inscritos',
                            data: noInscritos,
                            backgroundColor: '#E74C3C'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Estudiantes por Nivel'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
