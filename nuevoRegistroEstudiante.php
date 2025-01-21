<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Estudiante</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        input[type="text"],
        select {
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
            <h2 class="mb-3">Formulario de Registro de Estudiantes</h2>
            <form action="guardarNuevoEstudiante.php" method="POST">
                <!-- Información Académica -->
                <div class="mb-3 p-3" style="background-color: #2C3E50; border-radius: 10px;">
                    <h4 class="mb-2">Información Académica</h4>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="nivel" class="form-label">Nivel</label>
                            <select class="form-select" id="nivel" name="nivel" onchange="actualizarCursos()" required>
                                <option value="">Seleccione</option>
                                <option value="Inicial">Inicial</option>
                                <option value="Primario">Primario</option>
                                <option value="Secundario">Secundario</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="curso" class="form-label">Curso</label>
                            <select class="form-select" id="curso" name="curso" required>
                                <option value="">Seleccione Nivel Primero</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="paralelo" class="form-label">Paralelo</label>
                            <select class="form-select" id="paralelo" name="paralelo" required>
                                <option value="">Seleccione</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Información del Estudiante -->
                <div class="mb-3 p-3" style="background-color: #2C3E50; border-radius: 10px;">
                    <h4 class="mb-2">Información del Estudiante</h4>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="first_name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="last_name_father" class="form-label">A Paterno</label>
                            <input type="text" class="form-control" id="last_name_father" name="last_name_father">
                        </div>
                        <div class="col-md-4">
                            <label for="last_name_mother" class="form-label">A Materno</label>
                            <input type="text" class="form-control" id="last_name_mother" name="last_name_mother">
                        </div>
                    </div>
                    <div class="row mb-2">
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
                            <label for="birth_date" class="form-label">Fecha Nacimiento</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date">
                        </div>
                        <div class="col-md-3">
                            <label for="rude_number" class="form-label">RUDE</label>
                            <input type="text" class="form-control" id="rude_number" name="rude_number" required>
                        </div>
                    </div>
                </div>

                <!-- Información del Responsable -->
                <div class="mb-3 p-3" style="background-color: #2C3E50; border-radius: 10px;">
                    <h4 class="mb-2">Información del Responsable (Opcional)</h4>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="guardian_first_name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name">
                        </div>
                        <div class="col-md-4">
                            <label for="guardian_last_name" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name">
                        </div>
                        <div class="col-md-4">
                            <label for="guardian_identity_card" class="form-label">CI</label>
                            <input type="text" class="form-control" id="guardian_identity_card" name="guardian_identity_card">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="guardian_phone_number" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="guardian_phone_number" name="guardian_phone_number">
                        </div>
                        <div class="col-md-6">
                            <label for="guardian_relationship" class="form-label">Relación</label>
                            <select class="form-select" id="guardian_relationship" name="guardian_relationship">
                                <option value="">Seleccione</option>
                                <option value="padre">Padre</option>
                                <option value="madre">Madre</option>
                                <option value="tutor">Tutor</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Botón de Enviar -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        function actualizarCursos() {
            const nivel = document.getElementById('nivel').value;
            const curso = document.getElementById('curso');
            curso.innerHTML = '<option value="">Seleccione</option>';

            if (nivel === 'Inicial') {
                curso.innerHTML += '<option value="1">1</option><option value="2">2</option>';
            } else if (nivel === 'Primario' || nivel === 'Secundario') {
                for (let i = 1; i <= 6; i++) {
                    curso.innerHTML += `<option value="${i}">${i}</option>`;
                }
            }
        }
    </script>
</body>

</html>
