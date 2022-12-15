<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Viko akademinė sistema</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php

    require_once('Database/database.php');

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: /');
        exit;
    }

    if (Database::getUserRole($_SESSION['user']) !== 1) {
        header('Location: /');
        exit;
    }

    $studentId = $_SESSION['user'];
    $className = Database::getClassByStudent($studentId);
    $studentName = Database::getUserName($studentId);

    echo <<< HTML
    <hr>
    
    <h4 class="h4">${className['name']} - <i>${studentName}</i></h4>
    
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Grade</th>
            <th>Date</th>
        </tr>
        </thead>
    
        <tbody>
    HTML;

    $index = 0;

    foreach (Database::getGrades($studentId) as $grade) {
        $index++;

        echo <<< HTML
                    <tr>
                        <td>${index}</td>
                        <td>${grade['grade']}</td>
                        <td>${grade['date_created']}</td>
                    </tr>
        HTML;
    }

    ?>
</div>
</body>
</html>