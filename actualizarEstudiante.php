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
    $grade = $_POST['grade'] ?? null;
    $parallel = $_POST['parallel'] ?? null;

    // Datos del responsable
    $guardian_first_name = $_POST['guardian_first_name'] ?? null;
    $guardian_last_name = $_POST['guardian_last_name'] ?? null;
    $guardian_identity_card = $_POST['guardian_identity_card'] ?? null;
    $guardian_phone_number = $_POST['guardian_phone_number'] ?? null;
    $guardian_relationship = $_POST['guardian_relationship'] ?? null;

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
    $query = "
        UPDATE students 
        SET 
            rude_number = ?, 
            first_name = ?, 
            last_name_father = ?, 
            last_name_mother = ?, 
            gender = ?, 
            identity_card = ?, 
            birth_date = ?, 
            guardian_first_name = ?, 
            guardian_last_name = ?, 
            guardian_identity_card = ?, 
            guardian_phone_number = ?, 
            guardian_relationship = ? 
        WHERE rude_number = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssssssssssss",
        $rude_number,
        $first_name,
        $last_name_father,
        $last_name_mother,
        $gender,
        $identity_card,
        $birth_date,
        $guardian_first_name,
        $guardian_last_name,
        $guardian_identity_card,
        $guardian_phone_number,
        $guardian_relationship,
        $original_rude
    );

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
