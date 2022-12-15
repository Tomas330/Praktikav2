<?php

require_once('Database/database.php');

$id = $_GET['s'];

Database::removeStudent($id);

header('Location: admin.php');
exit;
