<?php

namespace App\Controllers;

use \Core\View;
use App\Models\UserService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class UsersController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $userServices = new UserService();
        $users = $userServices->readAll();

        /**
         * Render template for all users
         */

        View::renderTemplate('Users/index.html', [
            'users' => $users
        ]);

    }



}
