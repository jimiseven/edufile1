<?php

namespace App\Models;

use App\Core\Database;

class StudentCourse
{
    public function assign(int $studentId, int $courseId, string $status = 'Efectivo - I'): bool
    {
        $query = 'INSERT INTO student_courses (student_id, course_id, status) VALUES (?, ?, ?)';
        $stmt = Database::connection()->prepare($query);
        $stmt->bind_param('iis', $studentId, $courseId, $status);

        return $stmt->execute();
    }
}
