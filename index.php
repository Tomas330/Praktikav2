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
    <h1 class="h1 mt-5">Login</h1>

    <?php
        if (isset($_GET['e']) && $_GET['e'] === 'credentials') {
            echo <<< HTML
                <div class="alert alert-warning">
                  Invalid username or password
                </div>
            HTML;
        }
    ?>

    <div class="container m-5">
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="loginName">Name</label>
                <input type="text" class="form-control" id="loginName" name="name" placeholder="Name..." required>
            </div>

            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password..." required>
            </div>

            <div class="container mt-3">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>