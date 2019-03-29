<?php

namespace App\Controllers;

use App\Models\RoleService;
use \Core\View;
use App\Models\RolesService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class RolesController extends \Core\Controller
{
    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $roleServices = new RoleService();
        $roles = $roleServices->readAll();

        /**
         * Render template for all posts
         */

        View::renderTemplate('Roles/index.html', [
            'roles' => $roles
        ]);

    }

    /**
     * Show the add new page and create post
     *
     * @return void
     */
    public function addNewAction()
    {

        /**
         * Checking is it post - create post in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name   = $_POST['name'];
            $description = $_POST['description'];

            /**
             *
             * Validate title and content.
             * For testing we are checking does fields have exact content.
             *
             */
            if ($name == 'aaa') {
                $error_message = 'Greska - polje Name ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if ($description == 'aaa') {
                $error_message = 'Greska - polje description ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $roleServices = new RoleService();

                    $role = $roleServices->create($name, $description);


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

            View::renderTemplate('Roles/addRole.html', [
                'name' => $name,
                'description' => $description,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new post
         */

        View::renderTemplate('Roles/addRole.html');
    }

    /**
     * Edit action
     */

    public function editAction()
    {

        $id = $this->getRouteParams('id');

        /**
         * Checking is it POST - Take new content - Validate data - Update action
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id   = $_POST['id'];
            $name   = $_POST['name'];
            $description = $_POST['description'];

            /**
             * ITs Role!
             * validation of updated content
             */

            if ($name == 'aaa') {
                $error_message = 'Greska - polje NAME ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if ($description == 'aaa') {
                $error_message = 'Greska - polje Description ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            /**
             * Check errors
             */

            if (empty($this->getErrors())) {

                try {

                    $roleServices = new RoleService();

                    $role = $roleServices->update($id, $name, $description);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /roles/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Roles/editRole.html', [
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not POST and we render form with existing content
             */

            $roleServices = new RoleService();
            $role = $roleServices->readOne($id);

            $id = $role->getId();
            $name = $role->getName();
            $description = $role->getDescription();

            View::renderTemplate('Roles/editRole.html', [
                'id' => $id,
                'name' => $name,
                'description' => $description
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

                $roleServices = new RoleService();
                $role = $roleServices->delete($id);

                /* Redirect to index/All posts page */

                header('Location: /roles/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }

}
