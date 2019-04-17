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

        $permissionServices = new PermissionService();
        $permissions = $permissionServices->readAll();

        /**
         * Render template for all posts
         */

        View::renderTemplate('Permissions/index.html', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the add new page and create post
     *
     * @return void
     */

    /**
     * Show the add new page and create Book
     *
     * @return void
     */

    public function addNewAction()
    {

        $moduleServices = new ModuleService();
        $modules = $moduleServices->readAll();

        /**
         * Checking is it post - create book in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name   = $_POST['name'];
            $moduleid = $_POST['moduleid'];

            /**
             *
             * Validate name
             * For testing we are checking does fields have exact content.
             *
             */
            if ($name == 'aaa') {
                $error_message = 'Greska - polje Name ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }


            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $permissionServices = new PermissionService();

                    $permission = $permissionServices->create($name, $moduleid);


                    /* Redirect to index/All books page */
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

            View::renderTemplate('Permissions/addPermission.html', [
                'name' => $name,
                'module' => $moduleid,
                'errors' => $this->getErrors()

            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new book
         */

        View::renderTemplate('Permissions/addPermission.html', [
            'modules' => $modules
        ]);
        return;
    }

    /**
     * Edit action
     */

    public function editAction()
    {

        $id = $this->getRouteParams('id');

        $moduleServices = new ModuleService();
        $modules = $moduleServices->readAll();

        /**
         * Checking is it POST - Take new content - Validate data - Update action
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $name   = $_POST['name'];
            $module   = $_POST['module_id'];

            /**
             * Its post!
             * validation of updated content
             */

            if ($name == 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }




            /**
             * Check errors
             */

            if (empty($this->getErrors())) {

                try {

                    $permissionServices = new PermissionService();

                    $permission = $permissionServices->update($id, $name, $module);

                    /**
                     * Redirect to index/All perrmission page
                     */
                    header('Location: /permissions/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Permissions/editPermission.html', [
                'id' => $id,
                'name' => $name,
                'modules' => $modules,
                'module_id' => $module,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not Post and we render form with existing content
             */

            $permissionServices = new PermissionService();
            $permission = $permissionServices->readOne($id);

            $id = $permission->getId();
            $name = $permission->getName();
            $module = $permission->getModule();


            View::renderTemplate('Permissions/editPermission.html', [
                'id' => $id,
                'name' => $name,
                'modules' => $modules,
                'module_id' => $module
            ]);
        }

    }

    /**
     * Delete action
     */

    public function deleteAction()
    {

        /* Take id from route */

        $id = $this->getRouteParams("id");


        /**
         * Check is it post - delete post
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $permissionServices = new PermissionService();
                $permission = $permissionServices->delete($id);

                /* Redirect to index/All posts page */

                header('Location: /roles/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }

}
