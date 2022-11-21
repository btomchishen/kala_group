<?php

namespace App\Controllers;

use App\Models\Portal;
use \Core\View;
use \Service\Log;

class Home extends \Core\Controller
{

    public function indexAction()
    {
        if(!empty($_REQUEST['logout']) && $_REQUEST['logout'] == 'y') {
            $_SESSION['auth'] = false;
        }

        $loginError = false;
        if(!empty($_POST['login']) && !empty($_POST['password'])) {
            if($_POST['login'] == ADMIN_PANEL_LOGIN && $_POST['password'] == ADMIN_PANEL_PASSWORD ) {
                $_SESSION['auth'] = true;
            } else {
                $loginError = true;
            }
        }

        if(isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
            $portals = Portal::getAll();
            View::render('Home/list.php', [
                'portals' => $portals
            ]);
        } else {
            View::render('Home/index.php', [
                'loginError' => $loginError
            ]);
        }
    }

    public function editAction()
    {
        if(isset($_SESSION['auth']) && $_SESSION['auth'] === true) {

            if(isset($_REQUEST['update_fields']) && $_REQUEST['update_fields'] == 'Y') {
                Portal::update([
                    'active' => intval($_REQUEST['active']),
                    'use_local_install' => intval($_REQUEST['use_local_install']),
                    'c_rest_client_id' => $_REQUEST['c_rest_client_id'],
                    'c_rest_client_secret' => $_REQUEST['c_rest_client_secret'],
                    'portal_domain' => $_REQUEST['portal_domain'],
                    'client_endpoint' => $_REQUEST['client_endpoint'],
                    'lang' => $_REQUEST['lang'],
                    'access_token' => $_REQUEST['access_token'],
                    'refresh_token' => $_REQUEST['refresh_token'],
                    'member_id' => $_REQUEST['member_id'],
                    'application_token' => $_REQUEST['application_token'],
                    'status' => $_REQUEST['status'],
                    'protocol' => $_REQUEST['protocol'],
                    'placement' => $_REQUEST['placement'],
                    'wawe_client_id' => $_REQUEST['wawe_client_id'],
                    'wawe_client_secret' => $_REQUEST['wawe_client_secret'],
                    'wawe_access_token' => $_REQUEST['wawe_access_token'],
                    'wawe_scope' => $_REQUEST['wawe_scope'],
                    'wawe_refresh_token' => $_REQUEST['wawe_refresh_token'],
                    'wawe_grant_type' => $_REQUEST['wawe_grant_type'],
                    'wawe_userId' => $_REQUEST['wawe_userId'],
                    'wawe_businessId' => $_REQUEST['wawe_businessId']
                ]);

                header("Location: " . SITE_DOMAIN.RELATIVE_PATH);
                die();
            }

            $portal = Portal::getByField('id', $_REQUEST['id']);
            View::render('Home/edit.php', [
                'portal' => $portal
            ]);
        } else {
            header("Location: " . SITE_DOMAIN.RELATIVE_PATH);
            die();
        }
    }
}
