<?php

namespace App\Controllers\Admin;

use \Core\View;

/**
 * Admin Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        //echo "(before) ";
        //return false;
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo " (after)";
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        /*
        View::render('Home/index.php', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
        */
        View::renderTemplate('Admin/index.html', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
    }
}
