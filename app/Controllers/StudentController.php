<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Course;
use App\Models\Level;
use App\Models\Student;
use App\Models\StudentCourse;

class StudentController extends Controller
{
    public function index(): void
    {
        $studentModel = new Student();

        $this->view('students/index', [
            'title' => 'Lista de Estudiantes',
            'students' => $studentModel->allWithCourse(),
        ]);
    }

    public function create(): void
    {
        $levelModel = new Level();
        $courseModel = new Course();

        $this->view('students/create', [
            'title' => 'Registrar Estudiante',
            'levels' => $levelModel->all(),
            'coursesByLevel' => $courseModel->allGroupedByLevel(),
            'errors' => [],
            'old' => [],
        ]);
    }

    public function store(): void
    {
        $data = $this->studentDataFromRequest();
        $errors = $this->validateStudentData($data);

        $studentModel = new Student();
        if ($studentModel->existsByIdentityCard($data['identity_card'])) {
            $errors[] = 'El CI ya esta registrado.';
        }

        if ($studentModel->existsByRude($data['rude_number'])) {
            $errors[] = 'El RUDE ya esta registrado.';
        }

        $courseModel = new Course();
        $course = $courseModel->findByLevelGradeParallel($data['nivel'], (int) $data['curso'], $data['paralelo']);
        if ($course === null) {
            $errors[] = 'El curso seleccionado no existe.';
        }

        if (!empty($errors)) {
            $levelModel = new Level();

            $this->view('students/create', [
                'title' => 'Registrar Estudiante',
                'levels' => $levelModel->all(),
                'coursesByLevel' => $courseModel->allGroupedByLevel(),
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $conn = Database::connection();
        $conn->begin_transaction();

        try {
            $studentId = $studentModel->create($data);
            (new StudentCourse())->assign($studentId, (int) $course['id']);
            $conn->commit();

            header('Location: index.php?route=students&status=created');
            exit;
        } catch (\Throwable $exception) {
            $conn->rollback();

            $levelModel = new Level();

            $this->view('students/create', [
                'title' => 'Registrar Estudiante',
                'levels' => $levelModel->all(),
                'coursesByLevel' => $courseModel->allGroupedByLevel(),
                'errors' => ['No se pudo registrar el estudiante: ' . $exception->getMessage()],
                'old' => $data,
            ]);
        }
    }

    private function studentDataFromRequest(): array
    {
        return [
            'nivel' => trim($_POST['nivel'] ?? ''),
            'curso' => trim($_POST['curso'] ?? ''),
            'paralelo' => strtoupper(trim($_POST['paralelo'] ?? '')),
            'first_name' => strtoupper(trim($_POST['first_name'] ?? '')),
            'last_name_father' => strtoupper(trim($_POST['last_name_father'] ?? '')),
            'last_name_mother' => strtoupper(trim($_POST['last_name_mother'] ?? '')),
            'identity_card' => strtoupper(trim($_POST['identity_card'] ?? '')),
            'gender' => strtoupper(trim($_POST['gender'] ?? '')),
            'birth_date' => trim($_POST['birth_date'] ?? ''),
            'rude_number' => strtoupper(trim($_POST['rude_number'] ?? '')),
            'guardian_first_name' => strtoupper(trim($_POST['guardian_first_name'] ?? '')),
            'guardian_last_name' => strtoupper(trim($_POST['guardian_last_name'] ?? '')),
            'guardian_identity_card' => strtoupper(trim($_POST['guardian_identity_card'] ?? '')),
            'guardian_phone_number' => trim($_POST['guardian_phone_number'] ?? ''),
            'guardian_relationship' => trim($_POST['guardian_relationship'] ?? '') ?: null,
        ];
    }

    private function validateStudentData(array $data): array
    {
        $errors = [];

        if ($data['nivel'] === '') {
            $errors[] = 'Debe seleccionar un nivel.';
        }

        if ($data['curso'] === '') {
            $errors[] = 'Debe seleccionar un curso.';
        }

        if (!in_array($data['paralelo'], ['A', 'B', 'C'], true)) {
            $errors[] = 'Debe seleccionar un paralelo valido.';
        }

        if ($data['first_name'] === '') {
            $errors[] = 'Debe ingresar los nombres del estudiante.';
        }

        if ($data['last_name_father'] === '' && $data['last_name_mother'] === '') {
            $errors[] = 'Debe ingresar al menos un apellido.';
        }

        if (!in_array($data['gender'], ['M', 'F'], true)) {
            $errors[] = 'Debe seleccionar el sexo.';
        }

        if ($data['birth_date'] === '') {
            $errors[] = 'Debe ingresar la fecha de nacimiento.';
        }

        return $errors;
    }
}
