<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Registrar Estudiante</h2>
    <a href="index.php?route=students" class="btn btn-secondary">Volver al listado</a>
</div>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) : ?>
            <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="index.php?route=students/store" method="POST" class="panel p-4" id="studentCreateForm">
    <h4 class="mb-3">Informacion Academica</h4>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <label for="nivel" class="form-label">Nivel</label>
            <select class="form-select" id="nivel" name="nivel" required>
                <option value="">Seleccione</option>
                <?php foreach ($levels as $level) : ?>
                    <option value="<?= htmlspecialchars($level['name'], ENT_QUOTES, 'UTF-8') ?>" <?= (($old['nivel'] ?? '') === $level['name']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($level['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="curso" class="form-label">Curso</label>
            <select class="form-select" id="curso" name="curso" required>
                <option value="">Seleccione un nivel primero</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="paralelo" class="form-label">Paralelo</label>
            <select class="form-select" id="paralelo" name="paralelo" required>
                <option value="">Seleccione</option>
                <?php foreach (['A', 'B', 'C'] as $parallel) : ?>
                    <option value="<?= $parallel ?>" <?= (($old['paralelo'] ?? '') === $parallel) ? 'selected' : '' ?>><?= $parallel ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <h4 class="mb-3">Informacion del Estudiante</h4>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <label for="first_name" class="form-label">Nombres</label>
            <input type="text" class="form-control text-uppercase" id="first_name" name="first_name" value="<?= htmlspecialchars($old['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="last_name_father" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control text-uppercase" id="last_name_father" name="last_name_father" value="<?= htmlspecialchars($old['last_name_father'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="last_name_mother" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control text-uppercase" id="last_name_mother" name="last_name_mother" value="<?= htmlspecialchars($old['last_name_mother'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-3 mb-3">
            <label for="identity_card" class="form-label">CI</label>
            <input type="text" class="form-control text-uppercase" id="identity_card" name="identity_card" value="<?= htmlspecialchars($old['identity_card'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-3 mb-3">
            <label for="gender" class="form-label">Sexo</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">Seleccione</option>
                <option value="M" <?= (($old['gender'] ?? '') === 'M') ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= (($old['gender'] ?? '') === 'F') ? 'selected' : '' ?>>Femenino</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label for="birth_date" class="form-label">Fecha Nacimiento</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?= htmlspecialchars($old['birth_date'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="col-md-3 mb-3">
            <label for="rude_number" class="form-label">RUDE</label>
            <input type="text" class="form-control text-uppercase" id="rude_number" name="rude_number" value="<?= htmlspecialchars($old['rude_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
    </div>

    <h4 class="mb-3">Informacion del Responsable</h4>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <label for="guardian_first_name" class="form-label">Nombres</label>
            <input type="text" class="form-control text-uppercase" id="guardian_first_name" name="guardian_first_name" value="<?= htmlspecialchars($old['guardian_first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="guardian_last_name" class="form-label">Apellidos</label>
            <input type="text" class="form-control text-uppercase" id="guardian_last_name" name="guardian_last_name" value="<?= htmlspecialchars($old['guardian_last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="guardian_identity_card" class="form-label">CI Responsable</label>
            <input type="text" class="form-control text-uppercase" id="guardian_identity_card" name="guardian_identity_card" value="<?= htmlspecialchars($old['guardian_identity_card'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="guardian_phone_number" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="guardian_phone_number" name="guardian_phone_number" value="<?= htmlspecialchars($old['guardian_phone_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="guardian_relationship" class="form-label">Relacion</label>
            <select class="form-select" id="guardian_relationship" name="guardian_relationship">
                <option value="">Seleccione</option>
                <?php foreach (['padre' => 'Padre', 'madre' => 'Madre', 'tutor' => 'Tutor'] as $value => $label) : ?>
                    <option value="<?= $value ?>" <?= (($old['guardian_relationship'] ?? '') === $value) ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Registrar</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const coursesByLevel = <?= json_encode($coursesByLevel, JSON_UNESCAPED_UNICODE) ?>;
    const oldCourse = <?= json_encode($old['curso'] ?? '') ?>;
    const levelSelect = document.getElementById('nivel');
    const courseSelect = document.getElementById('curso');

    function loadCourses() {
        const level = levelSelect.value;
        const courses = coursesByLevel[level] || [];
        const grades = [...new Set(courses.map(function (course) { return String(course.grade); }))];

        courseSelect.innerHTML = '<option value="">Seleccione</option>';
        grades.forEach(function (grade) {
            const option = document.createElement('option');
            option.value = grade;
            option.textContent = grade;
            option.selected = oldCourse === grade;
            courseSelect.appendChild(option);
        });
    }

    levelSelect.addEventListener('change', loadCourses);
    loadCourses();
});
</script>
