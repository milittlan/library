<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Book;

/**
 * Book model
 * Controle ->Service
 * Service Book -> Service Category Book
 */
class BookService extends \Core\Model {

    /**
     * Get all the books as an associative array
     *
     * @return array
     */
    public static function readAll()
    {



        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, title, alias, author, publisher, category_id, status FROM books 
                                ORDER BY id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            /* Create empty array for entites */
            $books = [];

            /**
             * Check all posts - take value from array and put data array into Entity
             */

            foreach($results as $item) {

                $BookscategoryServices = new BookscategoryService();

                $book = new Book();

                $book->setId($item['id']);
                $book->setTitle($item['title']);
                $book->setAlias($item['alias']);
                $book->setAuthor($item['author']);
                $book->setPublisher($item['publisher']);
                $bookCategory = $BookscategoryServices->readOne($item['category_id']);
                $book->setCategory($bookCategory->getName());
                $book->setStatus($item['status']);

                /* add entity to array */
                array_push($books,  $book);
            }

           /* Return array of entities */
           return $books;


       } catch (PDOException $e) {
           echo $e->getMessage();
       }
   }


   /**
    * @param $id
    * @return Book
    *
    */
    public function readOne($id){

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all books from database
         */

        $stmt = $db->prepare("SELECT * FROM books WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $BookscategoryServices = new BookscategoryService();

        $book = new Book();

        $book->setId($results['id']);
        $book->setTitle($results['title']);
        $book->setAlias($results['alias']);
        $book->setAuthor($results['author']);
        $book->setPublisher($results['publisher']);
        $bookCategory = $BookscategoryServices->readOne($results['category_id']);
        $book->setCategory($bookCategory);
        $book->setStatus($results['status']);


        /* Return Entity */

        return $book;

    }

    /**
     * @param $title
     * @param $alias
     * @param $author
     * @param $publisher
     * @param $category_id
     * @param $status
     * @return bool
     */
    public function create($title, $alias, $author, $publisher, $category_id, $status)
    {

        $book = new Book();

        $book->setTitle($title);
        $book->setAlias($alias);
        $book->setAuthor($author);
        $book->setPublisher($publisher);
        $book->setCategory($category_id);
        $book->setStatus($status);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all books from database
         */

        $stmt = $db->prepare("INSERT INTO books (title, alias, author, publisher, category_id, status) VALUES (:title, :alias, :author, :publisher, :category_id, :status)");


        $title = $book->getTitle();
        $alias = $book->getAlias();
        $author = $book->getAuthor();
        $publisher = $book->getPublisher();
        $category_id = $book->getCategory();
        $status = $book->getStatus();


        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':publisher', $publisher, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        $results = $stmt->execute();

        /**
         * Return boolean
         */

        if ($results == true) {
            return true;
        } else {
            return false;
        }


    }


    /**
     * @param $id
     * @param $title
     * @param $alias
     * @param $author
     * @param $publisher
     * @param $category_id
     * @param $status
     * @return bool
     */
    public function update($id, $title, $alias, $author, $publisher, $category_id, $status)
    {
        /**
         * Take existing value from Book
         */

        $book = new Book();

        $book->setId($id);
        $book->setTitle($title);
        $book->setAlias($alias);
        $book->setAuthor($author);
        $book->setPublisher($publisher);
        $book->setCategory($category_id);
        $book->setStatus($status);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update book
         */

        $stmt = $db->prepare("UPDATE books SET title = :title, alias = :alias, author = :author, publisher = :publisher, category_id = :category_id, status = :status WHERE id = :id");

        $id = $book->getId();
        $title = $book->getTitle();
        $alias = $book->getAlias();
        $author = $book->getAuthor();
        $publisher = $book->getPublisher();
        $category_id = $book->getCategory();
        $status = $book->getStatus();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':publisher', $publisher, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        $results = $stmt->execute();


        /**
         * Return boolean
         */

        if ($results == true) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * @param $id
     * @return bool
     *
     */
    public function delete($id)
    {

        $book = new Book();

        $book->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete book
        */

        $stmt = $db->prepare("DELETE FROM books WHERE id = :id");

        $id = $book->getId();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        $results = $stmt->execute();


        /**
         * Return boolean
         */

        if ($results == true) {
            return true;
        } else {
            return false;
        }

    }


}