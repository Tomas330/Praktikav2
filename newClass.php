<?php

require_once('Database/database.php');

$className = $_POST['className'];
$teacher = $_POST['classTeacher'];

Database::createClass($className);
Database::setClassToTeacher(Database::getClassIdByClassName($className), $teacher);

header('Location: admin.php');
exit;
