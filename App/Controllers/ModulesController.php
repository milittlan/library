<?php

namespace App\Controllers;

use App\Models\ModuleService;
use \Core\View;
use App\Models\PostService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class ModulesController extends \Core\Controller  {

    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $moduleServices = new ModuleService();
        $modules = $moduleServices->readAll();

        /**
         * Render template for all posts
         */

        View::renderTemplate('Modules/index.html', [
            'modules' => $modules
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

            /**
             *
             * Validate title and content.
             * For testing we are checking does fields have exact content.
             *
             */
            if ($name == 'aaa') {
                $error_message = 'Greska - polje NAME ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }


            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $moduleServices = new ModuleService();

                    $module = $moduleServices->create($name);


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

            View::renderTemplate('Modules/addModule.html', [
                'name' => $name,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new post
         */

        View::renderTemplate('Modules/addModule.html');
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

            /**
             * ITs post!
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

                    $moduleServices = new ModuleService();

                    $module = $moduleServices->update($id, $name);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /modules/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Modules/editModule.html', [
                'id' => $id,
                'name' => $name,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not POST and we render form with existing content
             */

            $moduleServices = new ModuleService();
            $module = $moduleServices->readOne($id);

            $id = $module->getId();
            $name = $module->getName();

            View::renderTemplate('Modules/editModule.html', [
                'id' => $id,
                'name' => $name
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

                $moduleServices = new ModuleService();
                $module = $moduleServices->delete($id);

                /* Redirect to All modules page */

                header('Location: /modules/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }
}
