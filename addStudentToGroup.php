<?php

require_once('Database/database.php');

$classId = $_POST['classId'];
$studentId = $_POST['studentId'];

Database::addStudentToClass($studentId, $classId);

header('Location: admin.php');
exit;
