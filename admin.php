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
<?php

require_once('Database/database.php');

$rolesMap = [
    1 => 'student',
    2 => 'admin',
    3 => 'teacher'
];

?>

<div class="container mt-5">
    <h2 class="h2">Classes</h2>

    <div class="btn-group">
        <form action="newClass.php" method="POST">
            <input type="text" name="className" placeholder="Class name..." required>

            <select name="classTeacher" id="classTeacher">
                <?php

                foreach (Database::getAllFreeTeachers() as $teacher) {
                    echo '<option value="' . $teacher['id'] . '">' . $teacher['name'] . ' ' . $teacher['lastname'] . '</option>';
                }

                ?>
            </select>

            <button type="submit" class="btn btn-primary">Create new class</button>
        </form>
    </div>

    <?php
    foreach (Database::getClasses() as $className) {
        $teacherName = Database::getTeacherByClassName($className['name']);
        echo <<< HTML
                <hr>
            
                <h4 class="h4">${className['name']} - <i>${teacherName}</i></h4>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Lastname</th>
                        <th><a href="#" class="btn">✖</a></th>
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
                        <td><a href="/removeStudent.php?s=${student['id']}" class="btn">❌</a></td>
                    </tr>
            HTML;
        }

        $studensWithoutClass = Database::getAllStudentsWithoutClass();

        if ($studensWithoutClass) {
            echo <<< HTML
                    </tbody>
                </table>

                <form action="addStudentToGroup.php" method="POST">
                    <input type="hidden" value="${className['id']}" name="classId">
                
                    <div class="form-group">
                        <select name="studentId" id="studentId">
        HTML;

            foreach ($studensWithoutClass as $student) {
                echo '<option class="p-2" value="' . $student['id'] . '">' . $student['name'] . ' ' . $student['lastname'] . '</option>';
            }

            echo <<< HTML
                        </select>
                        
                        <button class="btn btn-primary" type="submit">Add student</button>
                    </div>
                </form>
        HTML;
        }

    }
    ?>
</div>

<div class="container mt-5">
    <h2 class="h2">Users</h2>

    <div class="btn-group">
        <form action="newUser.php" method="POST">
            <input type="text" name="name" placeholder="Name..." required>
            <input type="text" name="lastname" placeholder="Last name..." required>

            <select name="role" id="role">
                <?php
                foreach ($rolesMap as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
                ?>
            </select>

            <button type="submit" class="btn btn-primary">Create new user</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Lastname</th>
            <th>Role</th>
            <th><a href="#" class="btn">✖</a></th>
        </tr>
        </thead>

        <tbody>

        <?php
        foreach (Database::getAllUsers() as $user) {
            echo <<< HTML
                <tr>
                    <td>${user['name']}</td>
                    <td>${user['lastname']}</td>
                    <td>${rolesMap[$user['role']]}</td>
                    <td><a href="/deleteUser.php?u=${user['id']}" class="btn">❌</a></td>
                </tr>
            HTML;
        }
        ?>

        </tbody>
    </table>
</div>
</body>
</html>