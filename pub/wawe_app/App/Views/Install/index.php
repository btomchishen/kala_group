<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= GetMessage('INSTALL_TITLE'); ?></title>
    <link href="<?= RELATIVE_PATH ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= RELATIVE_PATH ?>/assets/css/custom.css" rel="stylesheet">

    <script src="//api.bitrix24.com/api/v1/"></script>
    <script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
    <script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-install">
            <?if(isset($result['install']) && $result['install'] === true):?>
            <p>
                <span class="install-title"><?= GetMessage('INSTALL_TEXT'); ?></span>
                <br>
                <a href="javascript:" onclick="BX24.installFinish();"><?= GetMessage('INSTALL_LINK_TEXT'); ?></a>
            </p>
                <script>
                    $(document).ready(function () {
                        BX24.init(function () {
                            BX24.installFinish();
                        });
                    });
                </script>
            <?else:?>
                <p>
                    <span class="install-title"><?= GetMessage('INSTALL_TEXT_ERROR'); ?></span>
                </p>
            <?endif;?>
        </div>
    </div>
</div>
</body>
</html>