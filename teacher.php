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

<div class="container mt-5">
    <?php

    require_once('Database/database.php');

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: /');
        exit;
    }

    if (Database::getUserRole($_SESSION['user']) !== 3) {
        header('Location: /');
        exit;
    }

    $teacherId = $_SESSION['user'];
    $teacherName = Database::getUserName($teacherId);
    $className = Database::getClassByTeacher($teacherId);

    echo <<< HTML
                <hr>
            
                <h4 class="h4">${className['name']} - <i>${teacherName}</i></h4>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Lastname</th>
                        <th>Grades</th>
                        <th>📝</th>
                    </tr>
                    </thead>
            
                    <tbody>
            HTML;

    $index = 0;
    foreach (Database::getStudentsFromClass($className['id']) as $student) {
        $index++;

        echo <<< HTML
                    <tr>
                        <td>${index}</td>
                        <td>${student['name']}</td>
                        <td>${student['lastname']}</td>
                        <td>
        HTML;


        foreach (Database::getGrades($student['id']) as $grade) {
            echo '<a class="mx-1" href="/editGradeForm.php?g=' . $grade['id'] . '" class="link-primary">' . $grade['grade'] . '</a>';
        }

        echo <<< HTML
                        </td>
                        <td>
                            <form action="addGrade.php" method="POST">
                                <input type="hidden" name="studentId" value="${student['id']}">
                            
                                <select name="grade" id="grade">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                                
                                <button type="submit" class="btn btn-primary">✏</button>
                            </form>
                        </td>
                    </tr>
            HTML;
    }

    ?>
</div>
</body>
</html>