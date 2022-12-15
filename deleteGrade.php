<?php

require_once('Database/database.php');

$gradeId = intval($_POST['gradeId']);

Database::deleteGrade($gradeId);

header('Location: teacher.php');
exit;
