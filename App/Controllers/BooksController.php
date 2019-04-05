<?php

namespace App\Controllers;

use App\Models\BookService;
use App\Models\BookscategoryService;
use \Core\View;

/**
 * Books controller
 *
 * PHP version 5.4
 */
class BooksController extends \Core\Controller  {

    /**
     * Show the index page
     *
     * @return void
     */

    public function indexAction()
    {

        $bookServices = new BookService();
        $books = $bookServices->readAll();

        $BookscategoryServices = new BookscategoryService();
        $categories = $BookscategoryServices->readOne(29);

        /**
         * Render template for all books
         */

        View::renderTemplate('Books/index.html', [
            'books' => $books,
            'categories' => $categories
        ]);
    }

    /**
     * Show the add new page and create Book
     *
     * @return void
     */

    public function addNewAction()
    {

        $BookscategoryServices = new BookscategoryService();
        $categories = $BookscategoryServices->readAll();

        /**
         * Checking is it post - create book in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title   = $_POST['title'];
            $alias = $_POST['alias'];
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $category_id = $_POST['categoryid'];
            $status = 0;

            /**
             *
             * Validate title
             * For testing we are checking does fields have exact content.
             *
             */
            if ($title == 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if (empty($alias)) {
                $alias = strtolower($title);
                $alias = preg_replace('/\s+/', '_', $alias);
            } else {
                $alias = strtolower($alias);
                $alias = preg_replace('/\s+/', '_', $alias);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $bookServices = new BookService();

                    $book = $bookServices->create($title, $alias, $author, $publisher, $category_id, $status);


                    /* Redirect to index/All books page */
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

            View::renderTemplate('Books/addBook.html', [
                'title' => $title,
                'alias' => $alias,
                'author' => $author,
                'publisher' => $publisher,
                'category_id' => $category_id,
                'status' => $status,
                'categories' => $categories,
                'errors' => $this->getErrors()

            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new book
         */

        View::renderTemplate('Books/addBook.html', [
            'categories' => $categories
            ]);
        return;
    }

    /**
     * Edit action
     */

    public function editAction()
    {

        $id = $this->getRouteParams('id');

        $BookscategoryServices = new BookscategoryService();
        $categories = $BookscategoryServices->readAll();

        /**
         * Checking is it POST - Take new content - Validate data - Update action
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id   = $_POST['id'];
            $title   = $_POST['title'];
            $alias = $_POST['alias'];
            $author   = $_POST['author'];
            $publisher   = $_POST['publisher'];
            $category_id   = $_POST['categoryid'];
            $status   = $_POST['status'];

            /**
             * Its post!
             * validation of updated content
             */

            if ($title == 'aaa') {
                $error_message = 'Greska - polje Title ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            if (empty($alias)) {
                $alias = strtolower($title);
                $alias = preg_replace('/\s+/', '_', $alias);
            } else {
                $alias = strtolower($alias);
                $alias = preg_replace('/\s+/', '_', $alias);
            }


            /**
             * Check errors
             */

            if (empty($this->getErrors())) {

                try {

                    $bookServices = new BookService();

                    $book = $bookServices->update($id, $title, $alias, $author, $publisher, $category_id, $status);

                    /**
                     * Redirect to index/All books page
                     */
                    header('Location: /books/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Books/editBook.html', [
                'id' => $id,
                'title' => $title,
                'alias' => $alias,
                'author' => $author,
                'publisher' => $publisher,
                'categories' => $categories,
                'category_id' => $category_id,
                'status' => $status,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not Book and we render form with existing content
             */

            $bookServices = new BookService();
            $book = $bookServices->readOne($id);

            $id = $book->getId();
            $title = $book->getTitle();
            $alias = $book->getAlias();
            $author = $book->getAuthor();
            $publisher = $book->getPublisher();
            $category_id = $book->getCategory();
            $status = $book->getStatus();

            View::renderTemplate('Books/editBook.html', [
                'id' => $id,
                'title' => $title,
                'alias' => $alias,
                'author' => $author,
                'publisher' => $publisher,
                'category_id' => $category_id,
                'categories' => $categories,
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
         * Check is it post - delete post
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $bookServices = new BookService();
                $book = $bookServices->delete($id);

                /* Redirect to index/All books page */

                header('Location: /books/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }
}
