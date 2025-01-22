usar
63882592

Cod: FB-BIN107
Cuenta SPOTIFY ANUAL
Correo : ewn3@outlook.es 
Contraseña : asd2777d

Fecha ini : 29 nov
Fecha fin : 29 nov 2024

Cod: FB-BIN108
Cuenta SPOTIFY ANUAL
Correo : whids@outlook.es 
Contraseña : asd23sss

Fecha ini : 29 nov
Fecha fin : 29 nov 2024


Reglas para las cuentas
• NO modificar los datos de la cuenta como EMAIL O CONTRASEÑA
• NO adicionar números de teléfono o celular
• NO modificar los datos del método de pago
• NO hacer uso de VPNs mientras se usa la app
Estos cambios afectan el pago de las cuentas, al ser internacionales, crean conflictos con los pagos y retraso en los mismos y la cuenta se cerrará
• En caso de tener algún problema, comunícate lo antes posible, se dara solucion y se repondra los dias perdidos.


nistt2@proton.me
sdb2BSbq3B2
sd2ed33bd


======
SuperUserm1
AngelaRomero134@outlook.com
9JgRwDa2Qm54


asdfijhkg287werDbhsae




===================


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFile - Estadísticas de Género y Estado</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <!-- Custom Styles -->
    <style>
    body {
        background-color: #1E2A38;
        /* Color de fondo original */
        color: #ffffff;
    }

    .sidebar {
        background-color: #000;
        /* Manteniendo el color del sidebar */
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

    .card-stat {
        background-color: #1F618D;
        /* Color de las tarjetas original */
        color: #ffffff;
        border: none;
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid #ffffff;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .chart-container {
        background-color: #2C3E50;
        /* Color original del gráfico */
        padding: 20px;
        border-radius: 15px;
        margin-top: 30px;
        max-width: 600px;
        /* Limitar el ancho máximo del gráfico */
        margin-left: auto;
        margin-right: auto;
    }

    .chart-title {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: bold;
        color: #ffffff;
    }

    #chartNivel {
        width: 100%;
        max-height: 300px;
        /* Ajustar la altura máxima del gráfico */
    }

    .nav-link.active {
        background-color: #1F618D;
    }

    h2 {
        color: #ffffff;
    }

    /* Mejoras en la responsividad */
    @media (max-width: 768px) {
        .card-stat {
            margin-bottom: 20px;
        }

        .chart-container {
            padding: 15px;
            max-width: 100%;
        }

        #chartNivel {
            max-height: 200px;
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
                    <div class="collapse ms-3" id="nivelMenu">
                        <a href="inicialCursos.php" class="nav-link"><i class="bi bi-circle"></i> Inicial</a>
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
            <h2 class="mb-4">Dashboard - Estadísticas de Género y Estado</h2>

            <!-- Stat Cards -->
            <div class="row g-4">
                <?php
                include 'conexion.php';

                // Consulta global para contar estudiantes por género y estado
                $queryGlobal = "SELECT 
                                    SUM(CASE WHEN gender = 'M' THEN 1 ELSE 0 END) AS hombres,
                                    SUM(CASE WHEN gender = 'F' THEN 1 ELSE 0 END) AS mujeres,
                                    SUM(CASE WHEN sc.status = 'Efectivo - I' THEN 1 ELSE 0 END) AS efectivos,
                                    SUM(CASE WHEN sc.status = 'No Inscrito' THEN 1 ELSE 0 END) AS no_inscritos
                                FROM students s
                                LEFT JOIN student_courses sc ON s.id = sc.student_id";
                $resultGlobal = $conn->query($queryGlobal);
                $globalData = $resultGlobal->fetch_assoc();

                // Consultar estadísticas por nivel, género y estado
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
                ?>

                <?php while ($level = $resultByLevel->fetch_assoc()) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-stat">
                        <div class="card-header">
                            <?php echo htmlspecialchars($level['level_name']); ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <h5><i class="bi bi-gender-ambiguous"></i> Género</h5>
                                    <p><i class="bi bi-gender-male"></i> Hombres: <?php echo $level['hombres']; ?></p>
                                    <p><i class="bi bi-gender-female"></i> Mujeres: <?php echo $level['mujeres']; ?></p>
                                </div>
                                <div class="col-6">
                                    <h5><i class="bi bi-list-check"></i> Estado</h5>
                                    <p><i class="bi bi-check-circle"></i> Efectivos: <?php echo $level['efectivos']; ?>
                                    </p>
                                    <p><i class="bi bi-x-circle"></i> No Inscritos:
                                        <?php echo $level['no_inscritos']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Totales Generales -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-stat">
                        <div class="card-header">
                            Totales Generales
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <h5><i class="bi bi-gender-ambiguous"></i> Género</h5>
                                    <p><i class="bi bi-gender-male"></i> Hombres: <?php echo $globalData['hombres']; ?>
                                    </p>
                                    <p><i class="bi bi-gender-female"></i> Mujeres:
                                        <?php echo $globalData['mujeres']; ?></p>
                                </div>
                                <div class="col-6">
                                    <h5><i class="bi bi-list-check"></i> Estado</h5>
                                    <p><i class="bi bi-check-circle"></i> Efectivos:
                                        <?php echo $globalData['efectivos']; ?></p>
                                    <p><i class="bi bi-x-circle"></i> No Inscritos:
                                        <?php echo $globalData['no_inscritos']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico -->
            <div class="chart-container mt-5">
                <h3 class="chart-title">Estudiantes por Género y Nivel</h3>
                <canvas id="chartNivel"></canvas>
            </div>

            <?php
            // Datos para el gráfico
            $chartData = [];
            $resultByLevel->data_seek(0); // Restablecer el puntero
            while ($row = $resultByLevel->fetch_assoc()) {
                $chartData[] = [
                    'level' => $row['level_name'],
                    'hombres' => $row['hombres'],
                    'mujeres' => $row['mujeres'],
                    'efectivos' => $row['efectivos'],
                    'no_inscritos' => $row['no_inscritos']
                ];
            }
            ?>
        </div> <!-- Fin de main-content -->
    </div> <!-- Fin de d-flex -->

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('chartNivel').getContext('2d');
        const data = <?php echo json_encode($chartData); ?>;

        const labels = data.map(item => item.level);
        const hombres = data.map(item => item.hombres);
        const mujeres = data.map(item => item.mujeres);
        const efectivos = data.map(item => item.efectivos);
        const noInscritos = data.map(item => item.no_inscritos);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Hombres',
                        data: hombres,
                        backgroundColor: '#1ABC9C'
                    },
                    {
                        label: 'Mujeres',
                        data: mujeres,
                        backgroundColor: '#E74C3C'
                    },
                    {
                        label: 'Efectivos',
                        data: efectivos,
                        backgroundColor: '#3498DB'
                    },
                    {
                        label: 'No Inscritos',
                        data: noInscritos,
                        backgroundColor: '#E67E22'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permitir que el gráfico se adapte al tamaño del contenedor
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: '#7f8c8d'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: '#7f8c8d'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Estudiantes por Género y Nivel',
                        color: '#ffffff'
                    }
                }
            }
        });
    });
    </script>
</body>

</html>