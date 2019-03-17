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
            $errors = '';

            /*
             * validate fields
             *
             */
            if ($title == 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if ($content== 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if (empty($error_message)) {

                try {

                    $post = PostService::create($title,$content, $error);

                    /*
                     * REdirect to index page
                     */
                    header('Location: index');

                    return;

                }  catch (\PDOException $e) {
                    $errors[] = $e->getMessage();
                }

            }

            $errors = getErrors($errors);

            View::renderTemplate('Posts/addPost.html', [
                'title' => $title,
                'content' => $content,
                'errors' => $errors
            ]);
            return;
        }

        /*
         *
         * Render form when we call action add new post
         *
         */
        View::renderTemplate('Posts/addPost.html');
    }

    /**
     *
     * Show the edit page
     *
     */
    public function editAction()
    {

        $id = $this->getRouteParams("id");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id   = $_POST['id'];
            $title   = $_POST['title'];
            $content = $_POST['content'];


            try {

                $post = PostService::update($id, $title, $content);

                View::renderTemplate('Posts/editPost.html', [
                    'post' => $post
                ]);
                return;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }

        } else {
            $post = PostService::readOne($id);
            View::renderTemplate('Posts/editPost.html', [
                'post' => $post
            ]);
        }

    }

    /**
     *
     * Delete Action
     *
     */
    public function deleteAction()
    {
        $id   = $_POST['id'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

            $posts = PostService::delete($id);

            View::renderTemplate('Posts/index.html', [
                'posts' => $posts
            ]);
            return;

            } catch (PDOException $e) {

                echo $e->getMessage();

            }
        }

    }
}
