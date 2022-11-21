<?php

namespace App\Controllers;

use App\Service\Wawe;
use \Core\View;
use \App\Models\Portal;
use \App\Service\CRest;
use \App\Service\ClearLogs;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class B24Frame extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $portal = Portal::getByDomain($_REQUEST['DOMAIN']);

        if(empty($portal['wawe_access_token'])) {
            $portal['wawe_client_id'] = '';
            $portal['wawe_client_secret'] = '';
        }

        if (empty($portal['wawe_client_id'])) {
            if (!empty($_REQUEST['WAWE_CLIENT_ID']) && !empty($_REQUEST['WAWE_CLIENT_SECRET'])) {
                $state = generatePassword();
                Portal::update([
                    'wawe_client_id' => $_REQUEST['WAWE_CLIENT_ID'],
                    'wawe_client_secret' => $_REQUEST['WAWE_CLIENT_SECRET'],
                    'wawe_state' => $state,
                    'portal_domain' => $_REQUEST['DOMAIN'],
                ]);
                header("Location: " . WAWE_URL_AUTH . "?client_id=" . $_REQUEST['WAWE_CLIENT_ID'] . "&response_type=code"."&scope=" . WAWE_URL_SCOPE."&state=".$state);
                die();
            }
            View::render('WaweConnect/step_1.php');
        } else {
            $wData = Wawe::getDetail($portal['wawe_access_token']);
            $portal['wawe'] = $wData;
            View::render('B24Frame/index.php', $portal);
        }
    }

    public function before()
    {
        parent::before();
        ClearLogs::clear();
        $validAccess = false;
        if (!empty($_REQUEST['DOMAIN']) && !empty($_REQUEST['AUTH_ID'])) {
            $validAccess = CRest::checkAccessParams($_REQUEST['DOMAIN'], $_REQUEST['AUTH_ID']);
        }
        if ($validAccess === false) {
            http_response_code(404);
            die('404');
        }
    }
}
