<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Book;

/**
 * Books controller
 *
 * PHP version 5.4
 */
class BookController extends \Core\Controller {

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $books = Book::getAll();

        View::renderTemplate('Books/index.html', [
            'books' => $books
        ]);
    }

    /**
     * Show form for the add new book
     *
     * @return void
     */
    public function addNewAction()
    {
        // echo 'Hello from the addNew action in the Books controller!';
        View::renderTemplate('Books/addBook.html');
    }

    /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the Books controller!';
        echo '<p>Route parameters: <pre>' .
            htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }

    /**
     *
     * Create new book
     *

    public function create()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            die('submit');

        }

    }
     * */

}
