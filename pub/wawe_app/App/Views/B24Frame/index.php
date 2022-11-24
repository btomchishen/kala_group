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
    <?
    $waweUser = '';
    $waweBusiness = '';
    if (!empty($wawe['data']['user']['defaultEmail'])) {
        $waweUser = $wawe['data']['user']['defaultEmail'];
    }
    if (is_array($wawe['data']['businesses']['edges'])) {
        foreach ($wawe['data']['businesses']['edges'] as $edge) {
            if ($wawe_businessId == $edge['node']['id']) {
                $waweBusiness = $edge['node']['name'];
            }
        }
    }
    ?>
    <div class="row">
        <div class="col-sm-6">
            <br>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Синхронизация</h5>
                    <p class="card-text">Ручная синхронизация данных</p>
                    <a id="exportButton"
                       href="<?= SITE_DOMAIN . RELATIVE_PATH . "/export?DOMAIN=" . $portal_domain . "&AUTH_ID=" . $access_token . "&getData=Y" ?>"
                       class="btn btn-primary">Старт</a>
                    <input id="dateRange" type="text" name="daterange" value="11/01/2022 - 11/30/2022"/>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <br>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Статус подключения</h5>
                    <p class="card-text">Подключено к wawe.<br> Пользователь: <?= $waweUser ?>
                        <br>Бизнес: <?= $waweBusiness ?></p>
                    <a href="<?= SITE_DOMAIN . RELATIVE_PATH . "/waweDisconect?DOMAIN=" . $portal_domain . "&AUTH_ID=" . $access_token . "&wawe_disconect=Y" ?>"
                       class="btn btn-danger">Отключить</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//api.bitrix24.com/api/v1/"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/classes/DataExporter.js"></script>
<!--DatePicker https://www.daterangepicker.com/ -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<!--DatePicker-->
<script>
    $(function () {
        /**
         * DateRangePicker
         */
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function (start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

        // $('#exportButton').click(function () {
        //     window.location = $(this).attr('href') + '&dateRange=' + $('#dateRange').val();
        //     return false;
        // });

        /**
         * Ajax data export
         */
        $('#exportButton').on('click', function (event) {
            let ajaxUrl = $(this).attr('href');
            let dateRange = $('#dateRange').val();
            console.log(ajaxUrl, dateRange)
            let exporter = new DataExporter(ajaxUrl, dateRange);

            exporter.doAjax(exporter.getAjaxUrl(), 'getLeadsCount', false);

            exporter.doAjax(exporter.getAjaxUrl(), 'leadsUpdate', true, {
                page: exporter.page,
                itemsPerPage: DataExporter.itemsPerPage
            });
        })
    });
</script>
</body>
</html>