<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Estudiante</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color: #1E2A38; color: #ffffff;">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="background-color: #283848; color: #ffffff;">
            <h3 class="text-center">EduFile</h3>
            <nav class="nav flex-column">
                <a href="#" class="nav-link text-white">Cursos</a>
                <a href="inicialCursos.php" class="nav-link text-white">Inicial</a>
                <a href="primariaCursos.php" class="nav-link text-white">Primaria</a>
                <a href="secundariaCursos.php" class="nav-link text-white">Secundaria</a>
                <a href="#" class="nav-link text-white">Estudiantes</a>
                <a href="#" class="nav-link text-white">Profesores</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4">
            <h2 class="mb-4">Formulario de Registro de Estudiantes</h2>
            <form action="guardarEstudiante.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="last_name_father" class="form-label">A Paterno</label>
                        <input type="text" class="form-control" id="last_name_father" name="last_name_father">
                    </div>
                    <div class="col-md-3">
                        <label for="last_name_mother" class="form-label">A Materno</label>
                        <input type="text" class="form-control" id="last_name_mother" name="last_name_mother">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="identity_card" class="form-label">CI</label>
                        <input type="text" class="form-control" id="identity_card" name="identity_card">
                    </div>
                    <div class="col-md-3">
                        <label for="gender" class="form-label">Sexo</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Seleccione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="birth_date" class="form-label">Fecha N</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date">
                    </div>
                    <div class="col-md-3">
                        <label for="rude_number" class="form-label">RUDE</label>
                        <input type="text" class="form-control" id="rude_number" name="rude_number" required>
                    </div>
                </div>
                <input type="hidden" name="grade" value="<?php echo htmlspecialchars($_GET['grade']); ?>">
                <input type="hidden" name="parallel" value="<?php echo htmlspecialchars($_GET['parallel']); ?>">
                <input type="hidden" name="status" value="No Inscrito">
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
