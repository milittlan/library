<?php

namespace App\Controllers;

use \Core\View;
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
            $error = '';

            if(empty($error)) {

                try {

                    $post = PostService::create($title,$content);
                    View::renderTemplate('Posts/addPost.html', [
                        'post' => $post
                    ]);
                    return;

                } catch (\PDOException $e) {

                    echo $e->getMessage();
                    $this->addErrors();

                }
            }
        }
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

            $post = PostService::update($id, $title,$content);

            View::renderTemplate('Posts/editPost.html', [
                'post' => $post
            ]);
            return;
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

            $posts = PostService::delete($id);

            View::renderTemplate('Posts/index.html', [
                'posts' => $posts
            ]);
            return;
        }

    }
}
