<?php
// Incluir conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $first_name = $_POST['first_name'];
    $last_name_father = $_POST['last_name_father'] ?? null;
    $last_name_mother = $_POST['last_name_mother'] ?? null;
    $identity_card = $_POST['identity_card'] ?? null;
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'] ?? null;
    $rude_number = $_POST['rude_number'];
    $grade = $_POST['grade'];
    $parallel = $_POST['parallel'];

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Insertar estudiante en la tabla students
        $studentQuery = "INSERT INTO students (first_name, last_name_father, last_name_mother, gender, rude_number, identity_card, birth_date)
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($studentQuery);
        $stmt->bind_param("sssssss", $first_name, $last_name_father, $last_name_mother, $gender, $rude_number, $identity_card, $birth_date);
        $stmt->execute();

        // Obtener el ID del estudiante insertado
        $student_id = $stmt->insert_id;

        // Obtener el ID del curso según el grado y paralelo
        $courseQuery = "SELECT id FROM courses WHERE grade = ? AND parallel = ? LIMIT 1";
        $stmt = $conn->prepare($courseQuery);
        $stmt->bind_param("ss", $grade, $parallel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $course = $result->fetch_assoc();
            $course_id = $course['id'];

            // Insertar en student_courses
            $studentCourseQuery = "INSERT INTO student_courses (student_id, course_id, status)
                                   VALUES (?, ?, 'Efectivo - I')";
            $stmt = $conn->prepare($studentCourseQuery);
            $stmt->bind_param("ii", $student_id, $course_id);
            $stmt->execute();

            // Confirmar transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: vistaGenCurso.php?grade=$grade&parallel=$parallel&success=1");
            exit;
        } else {
            throw new Exception("El curso no existe.");
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollback();

        // Redirigir con mensaje de error
        header("Location: nuevoEstudiante.php?grade=$grade&parallel=$parallel&error=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Redirigir si se accede al archivo directamente
    header("Location: index.php");
    exit;
}

$conn->close();
