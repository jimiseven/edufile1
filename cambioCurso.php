<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Obtener los niveles para el select
$queryLevels = "SELECT * FROM levels";
$resultLevels = $conn->query($queryLevels);
$levels = $resultLevels->fetch_all(MYSQLI_ASSOC);

// Inicializar variables
$student = null;
$success = false;
$error = null;

// Procesar búsqueda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_rude'])) {
    $rude_number = strtoupper($_POST['search_rude']);
    $query = "SELECT s.rude_number, s.first_name, s.last_name_father, s.last_name_mother, c.grade, c.parallel, l.id AS level_id, l.name AS level_name 
              FROM students s
              INNER JOIN student_courses sc ON s.id = sc.student_id
              INNER JOIN courses c ON sc.course_id = c.id
              INNER JOIN levels l ON c.level_id = l.id
              WHERE s.rude_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $rude_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $error = "No se encontró un estudiante con el RUDE proporcionado.";
    }
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $rude_number = strtoupper($_POST['rude_number']);
    $new_level_id = intval($_POST['level']);
    $new_course_grade = intval($_POST['course']);
    $new_parallel = strtoupper($_POST['parallel']);

    // Obtener el ID del curso basado en el nivel, curso y paralelo
    $queryCourseId = "SELECT id FROM courses WHERE grade = ? AND parallel = ? AND level_id = ?";
    $stmtCourseId = $conn->prepare($queryCourseId);
    $stmtCourseId->bind_param("isi", $new_course_grade, $new_parallel, $new_level_id);
    $stmtCourseId->execute();
    $resultCourseId = $stmtCourseId->get_result();

    if ($resultCourseId->num_rows > 0) {
        $course = $resultCourseId->fetch_assoc();
        $course_id = $course['id'];

        // Actualizar la tabla student_courses con el nuevo course_id
        $queryUpdate = "UPDATE student_courses 
                        SET course_id = ? 
                        WHERE student_id = (SELECT id FROM students WHERE rude_number = ?)";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("is", $course_id, $rude_number);

        if ($stmtUpdate->execute()) {
            $success = true;
        } else {
            $error = "Error al actualizar el nivel, curso o paralelo del estudiante.";
        }
    } else {
        $error = "El curso seleccionado no existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Nivel, Curso o Paralelo</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .form-section {
            background-color: #2C3E50;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            color: white;
        }

        .form-section h4 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body style="background-color: #1E2A38; color: white;">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cambiar Nivel, Curso o Paralelo</h2>

        <!-- Mensajes -->
        <?php if ($success): ?>
            <div class="alert alert-success">El estudiante fue actualizado correctamente.</div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario de Búsqueda -->
        <div class="form-section">
            <h4>Buscar Estudiante</h4>
            <form method="POST">
                <div class="mb-3">
                    <label for="search_rude" class="form-label">RUDE del Estudiante</label>
                    <input type="text" class="form-control" id="search_rude" name="search_rude" required>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>

        <!-- Formulario de Actualización -->
        <?php if ($student): ?>
            <div class="form-section">
                <h4>Actualizar Información del Estudiante</h4>
                <form method="POST">
                    <input type="hidden" name="rude_number" value="<?php echo htmlspecialchars($student['rude_number']); ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombre del Estudiante</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name_father'] . ' ' . $student['last_name_mother']); ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Nivel</label>
                        <select class="form-select" id="level" name="level" required onchange="loadCourses(this.value)">
                            <option value="">Seleccione un nivel</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?php echo $level['id']; ?>" <?php echo $student['level_id'] == $level['id'] ? 'selected' : ''; ?>>
                                    <?php echo $level['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="course" class="form-label">Curso</label>
                        <select class="form-select" id="course" name="course" required onchange="loadParallels(this.value)">
                            <option value="">Seleccione un curso</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="parallel" class="form-label">Paralelo</label>
                        <select class="form-select" id="parallel" name="parallel" required>
                            <option value="">Seleccione un paralelo</option>
                        </select>
                    </div>

                    <button type="submit" name="update_student" class="btn btn-success">Actualizar</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        // Cargar cursos dinámicamente según el nivel seleccionado
        function loadCourses(levelId) {
            const courseSelect = document.getElementById('course');
            const parallelSelect = document.getElementById('parallel');
            courseSelect.innerHTML = '<option value="">Cargando cursos...</option>';
            parallelSelect.innerHTML = '<option value="">Seleccione un paralelo</option>';

            fetch(`getCourses.php?level_id=${levelId}`)
                .then(response => response.json())
                .then(data => {
                    courseSelect.innerHTML = '<option value="">Seleccione un curso</option>';
                    data.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course.grade;
                        option.textContent = `Curso: ${course.grade}`;
                        courseSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar cursos:', error);
                    courseSelect.innerHTML = '<option value="">Error al cargar cursos</option>';
                });
        }

        // Cargar paralelos dinámicamente según el curso seleccionado
        function loadParallels(courseGrade) {
            const levelSelect = document.getElementById('level');
            const levelId = levelSelect.value;
            const parallelSelect = document.getElementById('parallel');
            parallelSelect.innerHTML = '<option value="">Cargando paralelos...</option>';

            fetch(`getParallels.php?course_grade=${courseGrade}&level_id=${levelId}`)
                .then(response => response.json())
                .then(data => {
                    parallelSelect.innerHTML = '<option value="">Seleccione un paralelo</option>';
                    data.forEach(parallel => {
                        const option = document.createElement('option');
                        option.value = parallel.parallel;
                        option.textContent = `Paralelo: ${parallel.parallel}`;
                        parallelSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar paralelos:', error);
                    parallelSelect.innerHTML = '<option value="">Error al cargar paralelos</option>';
                });
        }
    </script>
</body>

</html>
