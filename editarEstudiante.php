<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Verificar si se recibió el ID del estudiante
if (!isset($_GET['student_id']) || !isset($_GET['grade']) || !isset($_GET['parallel'])) {
    header("Location: vistaGenCurso.php?error=No se especificó un estudiante o curso");
    exit;
}

$student_id = $_GET['student_id'];
$grade = $_GET['grade'];
$parallel = $_GET['parallel'];

// Obtener datos del estudiante
$query = "SELECT * FROM students WHERE rude_number = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: vistaGenCurso.php?error=El estudiante no existe");
    exit;
}

$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        input[type="text"], select {
            text-transform: uppercase;
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
        <div class="main-content flex-grow-1 p-3" style="max-width: 1200px; margin: auto;">
            <h2 class="mb-3">Editar Estudiante</h2>
            <form action="actualizarEstudiante.php" method="POST">
                <input type="hidden" name="original_rude" value="<?php echo htmlspecialchars($student['rude_number']); ?>">
                <input type="hidden" name="grade" value="<?php echo htmlspecialchars($grade); ?>">
                <input type="hidden" name="parallel" value="<?php echo htmlspecialchars($parallel); ?>">
                <div class="mb-3 p-3" style="background-color: #2C3E50; border-radius: 10px;">
                    <h4 class="mb-2">Información del Estudiante</h4>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="first_name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="last_name_father" class="form-label">A Paterno</label>
                            <input type="text" class="form-control" id="last_name_father" name="last_name_father" value="<?php echo htmlspecialchars($student['last_name_father']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="last_name_mother" class="form-label">A Materno</label>
                            <input type="text" class="form-control" id="last_name_mother" name="last_name_mother" value="<?php echo htmlspecialchars($student['last_name_mother']); ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <label for="identity_card" class="form-label">CI</label>
                            <input type="text" class="form-control" id="identity_card" name="identity_card" value="<?php echo htmlspecialchars($student['identity_card']); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="gender" class="form-label">Sexo</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="M" <?php echo $student['gender'] === 'M' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="F" <?php echo $student['gender'] === 'F' ? 'selected' : ''; ?>>Femenino</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="birth_date" class="form-label">Fecha Nacimiento</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($student['birth_date']); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="rude_number" class="form-label">RUDE</label>
                            <input type="text" class="form-control" id="rude_number" name="rude_number" value="<?php echo htmlspecialchars($student['rude_number']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3 p-3" style="background-color: #2C3E50; border-radius: 10px;">
                    <h4 class="mb-2">Información del Responsable</h4>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="guardian_first_name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" value="<?php echo htmlspecialchars($student['guardian_first_name']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="guardian_last_name" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" value="<?php echo htmlspecialchars($student['guardian_last_name']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="guardian_identity_card" class="form-label">CI</label>
                            <input type="text" class="form-control" id="guardian_identity_card" name="guardian_identity_card" value="<?php echo htmlspecialchars($student['guardian_identity_card']); ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="guardian_phone_number" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="guardian_phone_number" name="guardian_phone_number" value="<?php echo htmlspecialchars($student['guardian_phone_number']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="guardian_relationship" class="form-label">Relación</label>
                            <select class="form-select" id="guardian_relationship" name="guardian_relationship">
                                <option value="padre" <?php echo $student['guardian_relationship'] === 'padre' ? 'selected' : ''; ?>>Padre</option>
                                <option value="madre" <?php echo $student['guardian_relationship'] === 'madre' ? 'selected' : ''; ?>>Madre</option>
                                <option value="tutor" <?php echo $student['guardian_relationship'] === 'tutor' ? 'selected' : ''; ?>>Tutor</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
