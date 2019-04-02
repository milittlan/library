<?php

namespace App\Controllers;

use App\Models\UserService;
use App\Models\RoleService;
use \Core\View;

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

    /**
     * Show the add new page and create User
     *
     * @return void
     */
    public function addNewAction()
    {

        $roleServices = new RoleService();
        $roles = $roleServices->readAll();

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

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $userServics = new UserService();

                    $user = $userServics->create($name, $description);


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

            View::renderTemplate('Users/addUser.html', [
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

        View::renderTemplate('Users/addUser.html', [
            'roles' => $roles
        ]);
        return;
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
             * ITs User!
             * validation of updated content
             */

            if ($name == 'aaa') {
                $error_message = 'Greska - polje NAME ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }


            /**
             * Check errors
             */

            if (empty($this->getErrors())) {

                try {

                    $userServices = new UserService();

                    $user = $userServices->update($id, $firstname, $lastname, $email, $password, $role_id, $status);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /users/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Users/editUser.html', [
                'id' => $id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'role_id' => $role_id,
                'status' => $status,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not POST and we render form with existing content
             */

            $userServices = new UserService();
            $user = $userServices->readOne($id);

            $id = $user->getId();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $email = $user->getEmail();
            $password = $user->getPassword();
            $role_id = $user->getRoleId();
            $status = $user->getStatus();

            View::renderTemplate('Users/editUser.html', [
                'id' => $id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'role_id' => $role_id,
                'status' => $status
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
         * Check is it post - delete User
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $userServices = new UserService();
                $user = $userServices->delete($id);

                /* Redirect to index/All posts page */

                header('Location: /users/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }

}
