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
            <br>
            <div class="alert alert-primary" role="alert">
                <?=GetMessage('FRAME_WAWE_CONNECT_TITLE')?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <form method="post">
                <input type="hidden" name="DOMAIN" value="<?=$_REQUEST['DOMAIN']?>">
                <input type="hidden" name="AUTH_ID" value="<?=$_REQUEST['AUTH_ID']?>">
                <input type="hidden" name="ACTION" value="SAVE_SECRET">
                <div class="form-group">
                    <label for="exampleInputEmail1">Client ID</label>
                    <input name="WAWE_CLIENT_ID" type="text" class="form-control" value="">
                    <small id="emailHelp" class="form-text text-muted">Wawe Client ID.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Client Secret</label>
                    <input name="WAWE_CLIENT_SECRET" type="text" class="form-control" value="">
                    <small id="emailHelp" class="form-text text-muted">Wawe Client Secret.</small>
                </div>
                <button type="submit" class="btn btn-primary"><?=GetMessage('BTN_CONNECT_TO_WAWE')?></button>
            </form>
        </div>
    </div>
</div>
<script src="//api.bitrix24.com/api/v1/"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>