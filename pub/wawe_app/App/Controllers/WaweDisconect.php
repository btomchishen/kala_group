<?php

namespace App\Controllers;

use App\Service\CRest;
use \App\Models\Portal;

class WaweDisconect extends \Core\Controller
{

    public function indexAction()
    {
        global $CPortal;
        if(!empty($CPortal)) {
            if(!empty($_REQUEST['wawe_disconect']) && $_REQUEST['wawe_disconect'] == 'Y'){
                Portal::update([
                    'wawe_client_id' => '',
                    'wawe_client_secret' => '',
                    'wawe_access_token' => '',
                    'wawe_token_type' => '',
                    'wawe_scope' => '',
                    'wawe_refresh_token' => '',
                    'wawe_userId' => '',
                    'wawe_businessId' => '',
                    'portal_domain' => $CPortal['portal_domain']
                ]);
                header("Location: " . SITE_DOMAIN.RELATIVE_PATH.'/app?DOMAIN='.$CPortal['portal_domain'].'&AUTH_ID='.$CPortal['access_token']);
                die();
            }
        }
    }

    public function before()
    {
        parent::before();
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
