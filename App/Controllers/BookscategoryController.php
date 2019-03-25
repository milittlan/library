<?php

namespace App\Controllers;

use \Core\View;
use App\Models\BookscategoryService;

/**
 * Bookcategory controller
 *
 * PHP version 5.4
 */
class BookscategoryController extends \Core\Controller {



    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $BookscategoryServices = new BookscategoryService();
        $categories = $BookscategoryServices->readAll();

        /**
         * Render template for all categories
         */

        View::renderTemplate('Bookscategory/index.html', [
            'categories' => $categories
        ]);
    }

    /**
     * Show form for the add new book category
     *
     * @return void
     */
    public function addNewAction()
    {
        /**
         * Checking is it post - create post in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $parent_id = $_POST['parent_id'];
            $level = $_POST['level'];
            $name   = $_POST['name'];
            $alias = $_POST['alias'];

            /**
             *
             * Validate name alias
             * For testing we are checking does field have exact content.
             *
             */
            if (!is_numeric($parent_id)) {
                $error_message = 'Greska - polje Parent ID  moze da sadrzi samo brojeve';
                $this->addError($error_message);
            }

            if (empty($alias)) {
                $alias = strtolower($name);
                $alias = str_replace(' ', '-', $alias);
            } else {
                $alias = str_replace(' ', '-', $alias);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $BookscategoryServices = new BookscategoryService();

                    $category = $BookscategoryServices->create($parent_id, $level, $name, $alias);


                    /* Redirect to index/All categories page */
                    header('Location: addNew');


                }  catch (\PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             *
             * IF EROOR is not empty - Display forms with error message and content.
             *
             */

            View::renderTemplate('Bookscategory/addCategory.html', [
                'parent_id' => $parent_id,
                'name' => $name,
                'alias' => $alias,
                'level' => $level,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new category
         */

        $BookscategoryServices = new BookscategoryService();
        $categories = $BookscategoryServices->readAllCategories();

        View::renderTemplate('Bookscategory/addCategory.html', [
            'categories' => $categories
        ]);
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

            $id = $_POST['id'];
            $parent_id = $_POST['parent_id'];
            $level = $_POST['level'];
            $name = $_POST['name'];
            $alias = $_POST['alias'];

            /**
             * ITs category!
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

                    $BookscategoryServices = new BookscategoryService();

                    $category = $BookscategoryServices->update($id, $parent_id, $level, $name, $alias);

                    /**
                     * Redirect to index/All categories page
                     */
                    header('Location: /bookscategory/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Posts/editPost.html', [
                'id' => $id,
                'parent_id' => $parent_id,
                'level' => $level,
                'name' => $name,
                'alias' => $alias,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not POST and we render form with existing category content
             */

            $BookscategoryServices = new BookscategoryService();
            $category = $BookscategoryServices->readOne($id);

            $id = $category->getId();
            $parent_id = $category->getParentId();
            $level = $category->getLevel();
            $name = $category->getName();
            $alias = $category->getAlias();

            View::renderTemplate('Bookscategory/editCategory.html', [
                'id' => $id,
                'parent_id' => $parent_id,
                'level' => $level,
                'name' => $name,
                'alias' => $alias
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

                $BookscategoryServices = new BookscategoryService();
                $category = $BookscategoryServices->delete($id);

                /* Redirect to index/All vategories page */

                header('Location: /bookscategory/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }



}
