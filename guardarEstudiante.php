<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name_father = $_POST['last_name_father'];
    $last_name_mother = $_POST['last_name_mother'];
    $identity_card = $_POST['identity_card'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $rude_number = $_POST['rude_number'];
    $grade = $_POST['grade'];
    $parallel = $_POST['parallel'];
    $status = $_POST['status']; // "No Inscrito"

    // Insertar nuevo estudiante en la tabla `students`
    $queryInsertStudent = "INSERT INTO students (first_name, last_name_father, last_name_mother, identity_card, gender, birth_date, rude_number)
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtStudent = $conn->prepare($queryInsertStudent);
    $stmtStudent->bind_param("sssssss", $first_name, $last_name_father, $last_name_mother, $identity_card, $gender, $birth_date, $rude_number);
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
