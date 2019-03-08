<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Post;

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
    public static function getPostById($id){
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");


            $stmt->execute(["id"=>$id]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
    * Update post
    *
    */
    public static function update($data)
    {
        try {


            // Create new entity from existing data
            $post = new Post();

            $post->setId($data['id']);
            $post->setContent($data["content"]);
            $post->setTitle($data["title"]);



            $db = static::getDB();
            $stmt = $db->prepare("UPDATE posts SET title = :title, content = :content, created_at = NOW() WHERE id = :id");

            $stmt->bindParam(':id', $post->getId(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $post->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':content', $post->getContent(), PDO::PARAM_STR);

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
    public static function delete($data)
    {
        try {

            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");

            $stmt->bindParam(':id', $data['id']);

            $results = $stmt->execute();

            return $results;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

}