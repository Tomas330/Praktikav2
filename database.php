<?php

require_once(dirname(__DIR__, 1) . '/mysql_connect.php');

class Database
{
    static public function getClasses(): array
    {
        global $db;

        $stmt = $db->prepare('SELECT id, name FROM class WHERE id != 0');
        $stmt->execute();

        $result = $stmt->get_result();

        $classes = [];

        while ($row = $result->fetch_assoc()) {
            $classes[] = $row;
        }

        return $classes;
    }

    static public function createClass($className): void
    {
        global $db;

        $stmt = $db->prepare('INSERT INTO class (name) VALUES (?)');
        $stmt->bind_param('s', $className);
        $stmt->execute();
    }

    static public function getStudentsFromClass($classId): array
    {
        global $db;

        $stmt = $db->prepare('SELECT id, name, lastname FROM user WHERE class = ? AND role = 1');
        $stmt->bind_param('i', $classId);
        $stmt->execute();

        $result = $stmt->get_result();

        $students = [];

        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        return $students;
    }

    static public function removeStudent($id): void
    {
        global $db;

        $stmt = $db->prepare('UPDATE user SET class = 0 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    static public function getAllStudentsWithoutClass(): array
    {
        global $db;

        $stmt = $db->prepare('SELECT id, name, lastname FROM user WHERE class = 0 AND role = 1');
        $stmt->execute();

        $result = $stmt->get_result();

        $students = [];

        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        return $students;
    }

    static public function addStudentToClass($studentId, $classId): void
    {
        global $db;

        $stmt = $db->prepare('UPDATE user SET class = ? WHERE id = ?');
        $stmt->bind_param('ii', $classId, $studentId);
        $stmt->execute();
    }

    static public function getAllUsers(): array
    {
        global $db;

        $stmt = $db->prepare('SELECT id, name, lastname, role FROM user');
        $stmt->execute();

        $result = $stmt->get_result();

        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    static public function deleteUser($id): void
    {
        global $db;

        $stmt = $db->prepare('DELETE FROM user WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    static public function getAllFreeTeachers(): array
    {
        global $db;

        $stmt = $db->prepare('SELECT id, name, lastname FROM user WHERE role = 3 AND class = 0');
        $stmt->execute();

        $result = $stmt->get_result();

        $teachers = [];

        while ($row = $result->fetch_assoc()) {
            $teachers[] = $row;
        }

        return $teachers;
    }

    static public function getClassIdByClassName($className): int
    {
        global $db;

        $stmt = $db->prepare('SELECT id FROM class WHERE name = ?');
        $stmt->bind_param('s', $className);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        return $result['id'];
    }

    static public function setClassToTeacher($className, $teacherId): void
    {
        global $db;

        $stmt = $db->prepare('UPDATE user SET class = ? WHERE id = ?');
        $stmt->bind_param('ss', $className, $teacherId);
        $stmt->execute();
    }

    static public function getTeacherByClassName($className): string
    {
        global $db;

        $classId = self::getClassIdByClassName($className);

        $stmt = $db->prepare('SELECT name, lastname FROM user WHERE class = ? AND role = 3');
        $stmt->bind_param('i', $classId);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        return $result['name'] . ' ' . $result['lastname'];
    }

    static public function getUserRole($id): int
    {
        global $db;

        $stmt = $db->prepare('SELECT role FROM user WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        return $result['role'];
    }

    static public function getClassByTeacher($teacherId): array
    {
        global $db;

        $stmt = $db->prepare('SELECT class FROM user WHERE id = ?');
        $stmt->bind_param('i', $teacherId);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        $classId = $result['class'];

        $stmt = $db->prepare('SELECT name FROM class WHERE id = ?');
        $stmt->bind_param('i', $classId);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        return [
            'id' => $classId,
            'name' => $result['name']
        ];
    }

    static public function getUserName($id): string
    {
        global $db;

        $stmt = $db->prepare('SELECT name, lastname FROM user WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        return $result['name'] . ' ' . $result['lastname'];
    }

    static public function addGrade(int $studentId, int $grade): void
    {
        global $db;

        $stmt = $db->prepare('INSERT INTO grades (studentId, grade) VALUES(?, ?)');
        $stmt->bind_param('si', $studentId, $grade);
        $stmt->execute();
    }

    static public function getGrades(int $studentId): array
    {
        global $db;

        $stmt = $db->prepare('SELECT id, grade, date_created FROM grades WHERE studentId = ?');
        $stmt->bind_param('i', $studentId);
        $stmt->execute();

        $result = $stmt->get_result();

        $grades = [];

        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }

        return $grades;
    }

    static public function editGrade(int $grade, int $gradeId): void
    {
        global $db;

        $stmt = $db->prepare('UPDATE grades SET grade = ? WHERE id = ?');
        $stmt->bind_param('ii', $grade, $gradeId);
        $stmt->execute();
    }

    static public function deleteGrade(int $gradeId): void
    {
        global $db;

        $stmt = $db->prepare('DELETE FROM grades WHERE id = ?');
        $stmt->bind_param('i', $gradeId);
        $stmt->execute();
    }

    static public function getClassByStudent(int $studentId): array
    {
        global $db;

        $stmt = $db->prepare('SELECT class FROM user WHERE id = ?');
        $stmt->bind_param('i', $studentId);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        $classId = $result['class'];

        $stmt = $db->prepare('SELECT name FROM class WHERE id = ?');
        $stmt->bind_param('i', $classId);
        $stmt->execute();

        $result = ($stmt->get_result())->fetch_assoc();

        return [
            'id' => $classId,
            'name' => $result['name']
        ];
    }
}
