<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="<?= RELATIVE_PATH ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= RELATIVE_PATH ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body class="text-center">
<form class="form-signin" method="POST" autocomplete="off">
    <img class="mb-4" src="<?= RELATIVE_PATH ?>/assets/images/wawe.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <?if(isset($loginError) && $loginError === true):?>
        <p style="color: red;">Incorrect login or password</p>
    <?endif;?>
    <label for="inputLogin" class="sr-only">Email address</label>
    <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus>
    <br>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
<script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>