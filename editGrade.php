<?php

require_once('Database/database.php');

$grade = intval($_POST['grade']);
$gradeId = intval($_POST['gradeId']);

Database::editGrade($grade, $gradeId);

header('Location: teacher.php');
exit;
