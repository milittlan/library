<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class HomeController extends \Core\Controller
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
        //return false;
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        View::renderTemplate('Home/index.html', [
            'name'    => 'Milan',
            'datas' => ['Milan', 'Markovic', 'Bild Studio']
        ]);
    }
}
