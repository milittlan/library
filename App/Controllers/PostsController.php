<?php

namespace App\Controllers;

use \Core\View;
use PDO;
use App\Models\PostService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class PostsController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $posts = PostService::readAll();


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

            $error = $this->getErrors();

            if (empty($error)) {

                try {

                    $post = PostService::create($title,$content);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: index');


                }  catch (\PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             *
             * Display forms with error message and content.
             *
             */
            View::renderTemplate('Posts/addPost.html', [
                'title' => $title,
                'content' => $content,
                'errors' => $error
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
     *
     * Edit action
     *
     */
    public function editAction()
    {

        $id = $this->getRouteParams("id");

        /**
         *
         * Check is it POST.
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

            $error = $this->getErrors();

            /**
             * Check errors
             */
            if (empty($error)) {

                try {

                    $post = PostService::update($id, $title, $content);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /posts/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            } else {
                /**
                 *
                 * Display forms with error message and content.
                 *
                 */
                View::renderTemplate('Posts/editPost.html', [
                    'id' => $id,
                    'title' => $title,
                    'content' => $content,
                    'errors' => $error
                ]);
                return;
            }

        } else {

            /**
             * Its not POST and we render form with existing content
             */

            $post = PostService::readOne($id);

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
     *
     * Delete action
     *
     */
    public function deleteAction()
    {

        $id = $this->getRouteParams("id");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $posts = PostService::delete($id);

                /**
                 * Redirect to index/All posts page
                 */
                header('Location: /posts/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }
}
