<?php
// Obtener la página actual
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<div class="sidebar p-3" style="background-color: #000; color: #fff; min-width: 250px;">
    <h3 class="text-center">EduFile</h3>
    <nav class="nav flex-column">
        <!-- Enlace para Inicio -->
        <a href="index.php" class="nav-link text-white <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
            <i class="bi bi-house-door"></i> Inicio
        </a>

        <!-- Menú desplegable para Niveles -->
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

        <!-- Enlace para Estudiantes -->
        <a class="nav-link text-white <?= ($currentPage == 'estudiantes.php') ? 'active' : '' ?>" href="estudiantes.php">
            <i class="bi bi-people"></i> Estudiantes
        </a>

        <!-- Enlace para Imprimir Listas -->
        <div class="mt-3">
            <a class="nav-link text-white <?= ($currentPage == 'imprimirListas.php') ? 'active' : '' ?>" href="imprimirListas.php" target="_blank">
                <i class="bi bi-printer"></i> Imprimir Listas - Respaldo
            </a>
        </div>
    </nav>
</div>