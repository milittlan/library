<?php

namespace App\Models;

use PDO;

/**
 * Book model
 */
class BookService extends \Core\Model {

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll()
    {

        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, title, author, publisher FROM books 
                                ORDER BY id');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
    public function addBook ($book)
    {
        try {
            $db = static::getDB();

            $stmt = $db->query("INSERT INTO books(title,author,publisher)
		                                               VALUES(:title, :author, :publisher)");

            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":author", $author);
            $stmt->bindparam(":publisher", $publisher);

            $stmt->execute();

            return $stmt;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
   */

}