<?php
// Incluir conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $original_rude = $_POST['original_rude'];
    $rude_number = $_POST['rude_number'];
    $first_name = $_POST['first_name'];
    $last_name_father = $_POST['last_name_father'] ?? null;
    $last_name_mother = $_POST['last_name_mother'] ?? null;
    $identity_card = $_POST['identity_card'] ?? null;
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'] ?? null;
    $grade = $_POST['grade'] ?? null; // Obtener el grado
    $parallel = $_POST['parallel'] ?? null; // Obtener el paralelo


    // Verificar si el RUDE ya existe
    $queryCheck = "SELECT * FROM students WHERE rude_number = ? AND rude_number != ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("ss", $rude_number, $original_rude);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        header("Location: editarEstudiante.php?student_id=$original_rude&error=El RUDE ya está registrado.");
        exit;
    }

    // Actualizar datos del estudiante
    $query = "UPDATE students SET rude_number = ?, first_name = ?, last_name_father = ?, last_name_mother = ?, gender = ?, identity_card = ?, birth_date = ? WHERE rude_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $rude_number, $first_name, $last_name_father, $last_name_mother, $gender, $identity_card, $birth_date, $original_rude);

    try {
        $stmt->execute();

        // Redirigir con mensaje de éxito al curso correspondiente
        header("Location: vistaGenCurso.php?grade=$grade&parallel=$parallel&success=1");
        exit;
    } catch (Exception $e) {
        // Redirigir con mensaje de error
        header("Location: editarEstudiante.php?student_id=$original_rude&error=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Redirigir si se accede al archivo directamente
    header("Location: index.php");
    exit;
}

$conn->close();
