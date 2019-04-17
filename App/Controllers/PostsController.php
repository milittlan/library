<?php

namespace App\Controllers;

use \Core\View;
use App\Models\PostService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class PostsController extends \Core\Controller  {

    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $postServices = new PostService();
        $posts = $postServices->readAll();

        /**
         * Render template for all posts
         */

        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
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

            $title   = $_POST['title'];
            $content = $_POST['content'];

            /**
             *
             * Validate title and content.
             * For testing we are checking does fields have exact content.
             *
             */
            if ($title == 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if ($content == 'aaa') {
                $error_message = 'Greska - polje Content ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $postServices = new PostService();

                    $post = $postServices->create($title, $content);


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

            View::renderTemplate('Posts/addPost.html', [
                'title' => $title,
                'content' => $content,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new post
         */

        View::renderTemplate('Posts/addPost.html');
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
            $title   = $_POST['title'];
            $content = $_POST['content'];

            /**
             * ITs post!
             * validation of updated content
             */

            if ($title == 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if ($content == 'aaa') {
                $error_message = 'Greska - polje Content ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            /**
             * Check errors
             */

            if (empty($this->getErrors())) {

                try {

                    $postServices = new PostService();

                    $post = $postServices->update($id, $title, $content);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /posts/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Posts/editPost.html', [
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not POST and we render form with existing content
             */

            $postServices = new PostService();
            $post = $postServices->readOne($id);

            $id = $post->getId();
            $title = $post->getTitle();
            $content = $post->getContent();

            View::renderTemplate('Posts/editPost.html', [
                'id' => $id,
                'title' => $title,
                'content' => $content
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

                $postServices = new PostService();
                $post = $postServices->delete($id);

                /* Redirect to index/All posts page */

                header('Location: /posts/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }

}
