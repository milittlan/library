<?php

namespace App\Controllers;

use \Core\View;
use App\Models\PackageService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class PackagesController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $packageServices = new PackageService();
        $packages = $packageServices->readAll();

        /**
         * Render template for all posts
         */

        View::renderTemplate('Packages/index.html', [
            'packages' => $packages
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
            $value = $_POST['value'];
            $duration = $_POST['duration'];
            $user_id = $_POST['userid'];

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

                    $packageServices = new PackageService();

                    $package = $packageServices->create($name, $value, $duration, $user_id);


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

            View::renderTemplate('Packages/addPackage.html', [
                'name' => $name,
                'value' => $value,
                'duration' => $duration,
                'user_id' => $user_id,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new post
         */

        View::renderTemplate('Packages/addPackage.html');
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
            $value = $_POST['value'];
            $duration = $_POST['duration'];
            $user_id = $_POST['user_id'];

            /**
             * ITs Package!
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

                    $packageServices = new PackageService();

                    $package = $packageServices->update($id, $name, $value, $duration, $user_id);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /packages/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Packages/editPackage.html', [
                'id' => $id,
                'name' => $name,
                'value' => $value,
                'duration' => $duration,
                'user_id' => $user_id,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not PACKAGE and we render form with existing content
             */

            $packageServices = new PackageService();
            $package = $packageServices->readOne($id);

            $id = $package->getId();
            $name = $package->getName();
            $value = $package->getValue();
            $duration = $package->getDuration();
            $user_id = $package->getUserId();

            View::renderTemplate('Packages/editPackage.html', [
                'id' => $id,
                'name' => $name,
                'value' => $value,
                'duration' => $duration,
                'user_id' => $user_id
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

                $packageServices = new PackageService();
                $package = $packageServices->delete($id);

                /* Redirect to index/All posts page */

                header('Location: /packages/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }
}
