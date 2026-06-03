<?php

namespace App\Models;

use App\Core\Database;

class Course
{
    public function allGroupedByLevel(): array
    {
        $query = '
            SELECT c.id, c.level_id, c.grade, c.parallel, l.name AS level_name
            FROM courses c
            INNER JOIN levels l ON c.level_id = l.id
            ORDER BY l.id ASC, c.grade ASC, c.parallel ASC
        ';

        $result = Database::connection()->query($query);

        if (!$result) {
            return [];
        }

        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[$row['level_name']][] = $row;
        }

        return $courses;
    }

    public function findByLevelGradeParallel(string $levelName, int $grade, string $parallel): ?array
    {
        $query = '
            SELECT c.id, c.level_id, c.grade, c.parallel
            FROM courses c
            INNER JOIN levels l ON c.level_id = l.id
            WHERE l.name = ? AND c.grade = ? AND c.parallel = ?
            LIMIT 1
        ';

        $stmt = Database::connection()->prepare($query);
        $stmt->bind_param('sis', $levelName, $grade, $parallel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return null;
        }

        return $result->fetch_assoc();
    }
}
