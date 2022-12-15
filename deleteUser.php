<?php

require_once('Database/database.php');

$userId = $_GET['u'];

Database::deleteUser($userId);

header('Location: admin.php');
exit;