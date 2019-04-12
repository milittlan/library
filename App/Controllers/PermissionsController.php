<?php

namespace App\Controllers;

use App\Models\ModuleService;
use App\Models\PermissionService;
use \Core\View;
use App\Models\PostService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class PermissionsController extends \Core\Controller  {

    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $permissionServices = new ModuleService();
        $permission = $permissionServices->readAll();

        /**
         * Render template for all posts
         */

        View::renderTemplate('Permissions/index.html', [
            'permission' => $permission
        ]);
    }

    /**
     * Show the add new page and create post
     *
     * @return void
     */


}
