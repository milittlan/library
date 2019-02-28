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
        $posts = PostService::getAll();

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

            $post = PostService::create($_POST);
            View::renderTemplate('Posts/addPost.html', [
                'post' => $post
            ]);
            return;
        }
        View::renderTemplate('Posts/addPost.html');
    }

    /**
     * Show the edit page
     *
     */
    public function editAction()
    {
        View::renderTemplate('Posts/editPost.html');
    }

    public function deleteAction()
    {

    }
}
