<?php

require_once(dirname(__DIR__, 1) . '/mysql_connect.php');

class User
{
    private string $name;
    private string $lastname;
    private int $role;
    private int $class;

    public function __construct()
    {

    }

    public function login(string $name, string $password): void
    {
        global $db;

        $stmt = $db->prepare('SELECT id, name, lastname, role, class FROM user WHERE name = ? AND password = ?');
        $stmt->bind_param('ss', $name, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            header('Location: index.php?e=credentials');
            exit();
        }

        $user = $result->fetch_assoc();

        $this->name = $user['name'];
        $this->lastname = $user['lastname'];
        $this->role = $user['role'];
        $this->class = $user['class'] ?? 0;

        session_start();
        $_SESSION['user'] = $user['id'];

        switch ($this->role) {
            case 1:
                header('Location: student.php');
                exit();
            case 2:
                header('Location: admin.php');
                exit();
            case 3:
                header('Location: teacher.php');
                exit();
        }
    }

    public function register($name, $lastname, $role): void
    {
        global $db;

        $stmt = $db->prepare('INSERT INTO user (name, lastname, role, password) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssis', $name, $lastname, $role, $lastname);
        $stmt->execute();
    }
}