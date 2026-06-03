<?php

namespace App\Models;

use App\Core\Database;

class Student
{
    public function allWithCourse(): array
    {
        $query = "
            SELECT
                s.rude_number,
                s.last_name_father,
                s.last_name_mother,
                s.first_name,
                l.name AS level_name,
                c.grade,
                c.parallel,
                sc.status
            FROM students s
            INNER JOIN student_courses sc ON s.id = sc.student_id
            INNER JOIN courses c ON sc.course_id = c.id
            INNER JOIN levels l ON c.level_id = l.id
            ORDER BY s.last_name_father ASC, s.last_name_mother ASC, s.first_name ASC
        ";

        $result = Database::connection()->query($query);

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function existsByIdentityCard(string $identityCard): bool
    {
        if ($identityCard === '') {
            return false;
        }

        $query = 'SELECT COUNT(*) AS total FROM students WHERE identity_card = ?';
        $stmt = Database::connection()->prepare($query);
        $stmt->bind_param('s', $identityCard);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return (int) $result['total'] > 0;
    }

    public function existsByRude(string $rudeNumber): bool
    {
        if ($rudeNumber === '') {
            return false;
        }

        $query = 'SELECT COUNT(*) AS total FROM students WHERE rude_number = ?';
        $stmt = Database::connection()->prepare($query);
        $stmt->bind_param('s', $rudeNumber);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return (int) $result['total'] > 0;
    }

    public function create(array $data): int
    {
        $query = '
            INSERT INTO students (
                first_name,
                last_name_father,
                last_name_mother,
                identity_card,
                gender,
                birth_date,
                rude_number,
                guardian_first_name,
                guardian_last_name,
                guardian_identity_card,
                guardian_phone_number,
                guardian_relationship
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ';

        $stmt = Database::connection()->prepare($query);
        $stmt->bind_param(
            'ssssssssssss',
            $data['first_name'],
            $data['last_name_father'],
            $data['last_name_mother'],
            $data['identity_card'],
            $data['gender'],
            $data['birth_date'],
            $data['rude_number'],
            $data['guardian_first_name'],
            $data['guardian_last_name'],
            $data['guardian_identity_card'],
            $data['guardian_phone_number'],
            $data['guardian_relationship']
        );
        $stmt->execute();

        return $stmt->insert_id;
    }
}
