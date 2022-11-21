<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List domains</title>
    <link href="<?= RELATIVE_PATH ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= RELATIVE_PATH ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col" style="height: 100px;">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?=RELATIVE_PATH?>">List domains</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=RELATIVE_PATH?>/?logout=y">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table id="domains" class="table" style="white-space:nowrap;">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Date create</th>
                        <th scope="col">Active</th>
                        <th scope="col">Local installation</th>
                        <th scope="col">Domain</th>
                        <th scope="col">Client id</th>
                        <th scope="col">Client Secret</th>
                        <th scope="col">Endpoint</th>
                        <th scope="col">Lang</th>
                        <th scope="col">Access Token</th>
                        <th scope="col">Refresh Token</th>
                        <th scope="col">Member Id</th>
                        <th scope="col">Application Token</th>
                        <th scope="col">Status</th>
                        <th scope="col">Protocol</th>
                        <th scope="col">Placement</th>
                        <th scope="col">Placement Options</th>
                        <th scope="col">Wawe Client Id</th>
                        <th scope="col">Wawe Client Secret</th>
                        <th scope="col">Wawe Access Token</th>
                        <th scope="col">Wawe Scope</th>
                        <th scope="col">Wawe Refresh Token</th>
                        <th scope="col">Wawe Grant Type</th>
                        <th scope="col">Wawe UserId</th>
                        <th scope="col">Wawe businessId</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($portals as $portal):?>
                        <tr>
                            <th scope="row"><?=$portal['id']?></th>
                            <th><a href="<?=RELATIVE_PATH?>/edit?id=<?=$portal['id']?>">Edit</a></th>
                            <td><?=$portal['date_create']?></td>
                            <td><?=$portal['active']==1?'Yes':'No'?></td>
                            <td><?=$portal['use_local_install']==1?'Yes':'No'?></td>
                            <td><?=$portal['portal_domain']?></td>
                            <td><?=$portal['c_rest_client_id']?></td>
                            <td><?=$portal['c_rest_client_secret']?></td>
                            <td><?=$portal['client_endpoint']?></td>
                            <td><?=$portal['lang']?></td>
                            <td><?=$portal['access_token']?></td>
                            <td><?=$portal['refresh_token']?></td>
                            <td><?=$portal['member_id']?></td>
                            <td><?=$portal['application_token']?></td>
                            <td><?=$portal['status']?></td>
                            <td><?=$portal['protocol']?></td>
                            <td><?=$portal['placement']?></td>
                            <td><?=$portal['placement_options']?></td>
                            <td><?=$portal['wawe_client_id']?></td>
                            <td><?=$portal['wawe_client_secret']?></td>
                            <td><?=$portal['wawe_access_token']?></td>
                            <td><?=$portal['wawe_scope']?></td>
                            <td><?=$portal['wawe_refresh_token']?></td>
                            <td><?=$portal['wawe_grant_type']?></td>
                            <td><?=$portal['wawe_userId']?></td>
                            <td><?=$portal['wawe_businessId']?></td>
                        </tr>
                    <?endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>