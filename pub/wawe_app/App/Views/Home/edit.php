<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
    <link href="<?= RELATIVE_PATH ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= RELATIVE_PATH ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body>
<div class="container">
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

            <form class="needs-validation" method="POST">
                <input type="hidden" name="update_fields" value="Y">
                <div class="mb-3">
                    <div>Id: <?=$portal['id']?></div>
                </div>

                <div class="mb-3">
                    <div>Date create: <?=$portal['date_create']?></div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="active">Active</label>
                        <select name="active" class="custom-select d-block w-100" id="active">
                            <option value="0" <?=empty($portal['active'])?'selected':''?>>No</option>
                            <option value="1" <?=empty($portal['active'])?'':'selected'?>>Yes</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                    </div>
                    <div class="col-md-3 mb-3">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="local_install">Local installation</label>
                        <select name="use_local_install" class="custom-select d-block w-100" id="local_install">
                            <option value="0" <?=empty($portal['use_local_install'])?'selected':''?>>No</option>
                            <option value="1" <?=empty($portal['use_local_install'])?'':'selected'?>>Yes</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                    </div>
                    <div class="col-md-3 mb-3">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="client_id">Client id</label>
                    <input name="c_rest_client_id" value="<?=$portal['c_rest_client_id']?>" type="text" class="form-control" id="client_id">
                </div>

                <div class="mb-3">
                    <label for="client_id">Client Secret</label>
                    <input name="c_rest_client_secret" value="<?=$portal['c_rest_client_secret']?>" type="text" class="form-control" id="client_id">
                </div>

                <div class="mb-3">
                    <label for="domain">Domain</label>
                    <input name="portal_domain" value="<?=$portal['portal_domain']?>" type="text" class="form-control" id="domain">
                </div>

                <div class="mb-3">
                    <label for="endpoint">Endpoint</label>
                    <input name="client_endpoint" value="<?=$portal['client_endpoint']?>" type="text" class="form-control" id="endpoint">
                </div>

                <div class="mb-3">
                    <label for="lang">Lang</label>
                    <input name="lang" value="<?=$portal['lang']?>" type="text" class="form-control" id="lang">
                </div>

                <div class="mb-3">
                    <label for="access_token">Access Token</label>
                    <input name="access_token" value="<?=$portal['access_token']?>" type="text" class="form-control" id="access_token">
                </div>

                <div class="mb-3">
                    <label for="refresh_token">Refresh Token</label>
                    <input name="refresh_token" value="<?=$portal['refresh_token']?>" type="text" class="form-control" id="refresh_token">
                </div>

                <div class="mb-3">
                    <label for="member_id">Member Id</label>
                    <input name="member_id" value="<?=$portal['member_id']?>" type="text" class="form-control" id="member_id">
                </div>

                <div class="mb-3">
                    <label for="application_token">Application Token</label>
                    <input name="application_token" value="<?=$portal['application_token']?>" type="text" class="form-control" id="application_token">
                </div>

                <div class="mb-3">
                    <label for="status">Status</label>
                    <input name="status" value="<?=$portal['status']?>" type="text" class="form-control" id="status">
                </div>

                <div class="mb-3">
                    <label for="Protocol">Protocol</label>
                    <input name="protocol" value="<?=$portal['protocol']?>" type="text" class="form-control" id="Protocol">
                </div>

                <div class="mb-3">
                    <label for="Placement">Placement</label>
                    <input name="placement" value="<?=$portal['placement']?>" type="text" class="form-control" id="Placement">
                </div>

                <div class="mb-3">
                    <label for="Wawe_Client_Id">Wawe Client Id</label>
                    <input name="wawe_client_id" value="<?=$portal['wawe_client_id']?>" type="text" class="form-control" id="Wawe_Client_Id">
                </div>

                <div class="mb-3">
                    <label for="Wawe_Client_Secret">Wawe Client Secret</label>
                    <input name="wawe_client_secret" value="<?=$portal['wawe_client_secret']?>" type="text" class="form-control" id="Wawe_Client_Secret">
                </div>

                <div class="mb-3">
                    <label for="Wawe_Access_Token">Wawe Access Token</label>
                    <input name="wawe_access_token" value="<?=$portal['wawe_access_token']?>" type="text" class="form-control" id="Wawe_Access_Token">
                </div>

                <div class="mb-3">
                    <label for="Wawe_Scope">Wawe Scope</label>
                    <input name="wawe_scope" value="<?=$portal['wawe_scope']?>" type="text" class="form-control" id="Wawe_Scope">
                </div>

                <div class="mb-3">
                    <label for="Wawe_Refresh_Token">Wawe Refresh Token</label>
                    <input name="wawe_refresh_token" value="<?=$portal['wawe_refresh_token']?>" type="text" class="form-control" id="Wawe_Refresh_Token">
                </div>

                <div class="mb-3">
                    <label for="Wawe_Grant_Type">Wawe Grant Type</label>
                    <input name="wawe_grant_type" value="<?=$portal['wawe_grant_type']?>" type="text" class="form-control" id="Wawe_Grant_Type">
                </div>

                <div class="mb-3">
                    <label for="Wawe_UserId">Wawe UserId</label>
                    <input name="wawe_userId" value="<?=$portal['wawe_userId']?>" type="text" class="form-control" id="Wawe_UserId">
                </div>

                <div class="mb-3">
                    <label for="Wawe_businessId">Wawe businessId</label>
                    <input name="wawe_businessId" value="<?=$portal['wawe_businessId']?>" type="text" class="form-control" id="Wawe_businessId">
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
            </form>

        </div>
    </div>
</div>
<script src="<?= RELATIVE_PATH ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/popper.min.js"></script>
<script src="<?= RELATIVE_PATH ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>