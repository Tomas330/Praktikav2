<?php

require_once('Classes/User.php');

(new User())->login($_POST['name'], $_POST['password']);


