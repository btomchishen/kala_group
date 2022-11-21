<?php

namespace App\Controllers;

use \App\Service\Wawe;
use \App\Models\Portal;

class WaweConnect extends \Core\Controller
{

    public function indexAction()
    {
        if(!empty($_REQUEST['state']) && !empty($_REQUEST['code'])) {
            $result = Wawe::getToken($_REQUEST['state'], $_REQUEST['code']);
            if(!empty($result['access_token']) && !empty($result['portal_domain'])){
                Portal::update([
                    'wawe_access_token' => $result['access_token'],
                    'wawe_token_type' => $result['token_type'],
                    'wawe_scope' => $result['scope'],
                    'wawe_refresh_token' => $result['refresh_token'],
                    'wawe_userId' => $result['userId'],
                    'wawe_businessId' => $result['businessId'],
                    'portal_domain' => $result['portal_domain']
                ]);

                header("Location: " . SITE_DOMAIN.RELATIVE_PATH.'/app?DOMAIN='.$result['portal_domain'].'&AUTH_ID='.$result['access_token']);
                die();
            }
        }
    }

}
