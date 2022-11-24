<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= GetMessage('FRAME_TITLE'); ?></title>
    <link href="<?= RELATIVE_PATH ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= RELATIVE_PATH ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand active" href="#">Главная</a>
                <a class="navbar-brand" href="#">Настройки</a>
            </nav>
        </div>
    </div>
    <div class="row">
        <pre>
<!--            --><?//print_r($contacts)?>
<!--            --><?//print_r($products)?>
<!--            --><?//print_r($invoices)?>
        </pre>
    </div>
</div>
<script src="//api.bitrix24.com/api/v1/"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/classes/DataExporter.js"></script>
</body>
</html>