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
class Install extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $result = CRest::installApp();
        if($result['install'] === true) {
            $resUninstall = CRest::call('event.bind',[
                'event' => 'ONAPPUNINSTALL',
                'handler' => SITE_DOMAIN.RELATIVE_PATH.'/uninstall'
            ]);
        }
        View::render('Install/index.php', array('result' => $result));
    }

    public function before()
    {
        parent::before();
    }
}
