<?php

namespace App\Controllers;

use App\Models\ModuleService;
use App\Models\PermissionService;
use App\Models\RolePermissionService;
use App\Models\RoleService;
use \Core\View;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class RolesPermissionsController extends \Core\Controller
{

    public function indexAction()
    {



        $rolepermissionServices = new RolePermissionService();
        $rolesPermissions = $rolepermissionServices->readAll();

        /**
         * Render template for all users
         */

        View::renderTemplate('RolesPermissions/index.html', [
            'rolespermissions' => $rolesPermissions
        ]);

    }

    public function addNewAction()
    {
        $permissionServices = new PermissionService();
        $permissions = $permissionServices->readAll();

        $roleServices = new RoleService();
        $roles = $roleServices->readAll();

        $moduleServices = new ModuleService();
        $modules = $moduleServices->readAll();


        /**
         * Checking is it post - create reservation in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $roleid   = $_POST['roleid'];
            $permissionid = $_POST['permissionid'];
            $moduleid = $_POST['moduleid'];

            /**
             *
             * Validate description.
             * For testing we are checking does fields have exact content.
             *
             */
            if ($roleid == 'aaa') {
                $error_message = 'Greska - polje description ne moze dabude prazno';
                $this->addError($error_message);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $rolepermissionServices = new RolePermissionService();

                    $rolepermission = $rolepermissionServices->create($roleid, $permissionid, $moduleid);


                    /* Redirect to index/All posts page */
                    header('Location: index');


                }  catch (\PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             *
             * IF EROOR is not empty - Display forms with error message and content.
             *
             */

            View::renderTemplate('RolesPermissions/addRolePermission.html', [
                'roleid' => $roleid,
                'permissionid' => $permissionid,
                'moduleid' => $moduleid,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new post
         */

        View::renderTemplate('RolesPermissions/addRolePermission.html', [
            'roles' => $roles,
            'modules' => $modules,
            'permissions' => $permissions
        ]);
        return;
    }

}
