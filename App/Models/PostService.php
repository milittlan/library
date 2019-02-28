<?php

namespace App\Models;

use PDO;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */
class PostService extends \Core\Model {

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll()
    {

        try {

            $db = static::getDB();

            $stmt = $db->query('SELECT id, title, content FROM posts 
                                ORDER BY created_at');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     *
     * Get post by ID
     *
     */
    public function getPostId($id){

    }

    /*
     *
     * ADD NEW POST
     *
     */
    public static function create($data)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO posts (title, content, created_at) VALUES (:title, :content, NOW())");
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
            $results = $stmt->execute();
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     *
     * Delete post
     *
     */
    public static function delete()
    {

    }

}