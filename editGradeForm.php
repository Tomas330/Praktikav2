<?php

require_once('Database/database.php');

$id = $_GET['g'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

<div class="d-flex justify-content-center align-items-center" style="height:500px;">
        <form action="editGrade.php" method="POST">
            <h2 class="mb-5">Edit grade</h2>
            <input type="hidden" name="gradeId" value="<?php echo $id ?>">

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

            <button type="submit" class="btn btn-primary" formaction="editGrade.php">Edit</button>
            <button type="submit" class="btn btn-danger" formaction="deleteGrade.php">Delete</button>
        </form>
</div>
</body>
</html>
