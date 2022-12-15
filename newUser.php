<?php

require_once('Database/database.php');
require_once('Classes/User.php');

$name = $_POST['name'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];

(new User())->register($name, $lastname, $role);

header('Location: admin.php');
exit;
