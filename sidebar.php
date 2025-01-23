<!-- sidebar.php -->
<div class="sidebar p-3" style="background-color: #000; color: #fff; min-width: 250px;">
    <h3 class="text-center">EduFile</h3>
    <nav class="nav flex-column">
        <a href="index.php" class="nav-link text-white">
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
        <a class="nav-link text-white" href="estudiantes.php">
            <i class="bi bi-people"></i> Estudiantes
        </a>
        <!-- Nuevo botón añadido al final del sidebar -->
        <div class="mt-3">
            <a class="nav-link text-white" href="imprimirListas.php" target="_blank">
                <i class="bi bi-printer"></i> Imprimir Listas - Respaldo
            </a>
        </div>
    </nav>
</div>
