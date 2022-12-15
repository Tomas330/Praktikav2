<?php

require_once('Database/database.php');

$studentId = $_POST['studentId'];
$grade = $_POST['grade'];

Database::addGrade($studentId, $grade);

header('Location: teacher.php');
exit;
