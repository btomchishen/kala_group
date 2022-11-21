<?php

namespace App\Controllers;

use App\Models\Portal;
use \Core\View;
use \App\Service\CRest;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Uninstall extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        CRest::setLog(['DELETE PORTAL START', $_REQUEST]);
        $domain = empty($_REQUEST['domain'])?'':$_REQUEST['domain'];
        $application_token = empty($_REQUEST['auth']['application_token'])?'':$_REQUEST['auth']['application_token'];
        if(!empty($domain) && !empty($application_token)) {
            $portal = Portal::getByDomain($_REQUEST['domain']);
            CRest::setLog(['DELETE PORTAL', $portal]);
            if(!empty($portal) && $portal['application_token'] == $application_token) {
                CRest::setLog(['DELETE PORTAL', 'SUCCESS']);
                Portal::delete($portal['id']);
            }
        }
    }

}
