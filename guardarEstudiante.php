<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del estudiante
    $first_name = strtoupper($_POST['first_name']);
    $last_name_father = strtoupper($_POST['last_name_father']);
    $last_name_mother = strtoupper($_POST['last_name_mother']);
    $identity_card = strtoupper($_POST['identity_card']);
    $gender = strtoupper($_POST['gender']);
    $birth_date = $_POST['birth_date']; // No es necesario convertir fechas a mayúsculas
    $rude_number = strtoupper($_POST['rude_number']);
    $grade = strtoupper($_POST['grade']);
    $parallel = strtoupper($_POST['parallel']);
    $status = strtoupper($_POST['status']); // "No Inscrito"

    // Datos del responsable
    $guardian_first_name = strtoupper($_POST['guardian_first_name']);
    $guardian_last_name = strtoupper($_POST['guardian_last_name']);
    $guardian_identity_card = strtoupper($_POST['guardian_identity_card']);
    $guardian_phone_number = strtoupper($_POST['guardian_phone_number']);
    $guardian_relationship = strtoupper($_POST['guardian_relationship']);

    // Insertar nuevo estudiante en la tabla `students`
    $queryInsertStudent = "
        INSERT INTO students (
            first_name, last_name_father, last_name_mother, identity_card, gender, birth_date, rude_number,
            guardian_first_name, guardian_last_name, guardian_identity_card, guardian_phone_number, guardian_relationship
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $stmtStudent = $conn->prepare($queryInsertStudent);
    $stmtStudent->bind_param(
        "ssssssssssss",
        $first_name,
        $last_name_father,
        $last_name_mother,
        $identity_card,
        $gender,
        $birth_date,
        $rude_number,
        $guardian_first_name,
        $guardian_last_name,
        $guardian_identity_card,
        $guardian_phone_number,
        $guardian_relationship
    );
    $stmtStudent->execute();
    $student_id = $stmtStudent->insert_id;

    // Insertar el estado predeterminado en la tabla `student_courses`
    $queryInsertCourse = "INSERT INTO student_courses (student_id, course_id, status)
                          VALUES (?, (SELECT id FROM courses WHERE grade = ? AND parallel = ? LIMIT 1), ?)";
    $stmtCourse = $conn->prepare($queryInsertCourse);
    $stmtCourse->bind_param("isss", $student_id, $grade, $parallel, $status);
    $stmtCourse->execute();

    // Redirigir a la vista del curso
    header("Location: vistaGenCurso.php?grade=$grade&parallel=$parallel&success=1");
    exit;
}
?>
