<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Lista de Estudiantes</h2>
    <a href="index.php?route=students/create" class="btn btn-success">Nuevo estudiante</a>
</div>

<?php if (($_GET['status'] ?? '') === 'created') : ?>
    <div class="alert alert-success">Estudiante registrado correctamente.</div>
<?php endif; ?>

<div class="d-flex mb-3" style="max-width: 520px;">
    <input type="text" id="searchStudent" class="form-control me-2" placeholder="Buscar por nombre, apellido, RUDE, nivel o curso...">
    <button class="btn btn-danger" id="clearSearch" type="button">&times;</button>
</div>

<div class="panel table-responsive">
    <table class="table mb-0" id="studentsTable">
        <thead>
            <tr>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombres</th>
                <th>Nivel</th>
                <th>Curso</th>
                <th>Paralelo</th>
                <th>Estado</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)) : ?>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?= htmlspecialchars($student['last_name_father'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($student['last_name_mother'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($student['first_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($student['level_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($student['grade'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($student['parallel'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="../editarEstudiante.php?student_id=<?= urlencode($student['rude_number']) ?>&source=students_mvc" class="btn btn-primary btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">No hay estudiantes disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchStudent');
    const clearButton = document.getElementById('clearSearch');
    const rows = Array.from(document.querySelectorAll('#studentsTable tbody tr'));

    function filterRows() {
        const value = searchInput.value.toLowerCase();

        rows.forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRows);
    clearButton.addEventListener('click', function () {
        searchInput.value = '';
        filterRows();
        searchInput.focus();
    });
});
</script>
