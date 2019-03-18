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
    public static function readAll()
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
    public static function readOne($id){
        try {

            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");

            $stmt->execute(["id"=>$id]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            $id = $results['id'];
            $title = $results['title'];
            $content = $results['content'];

            $post = new Post();

            $post->setId($id);
            $post->setContent($content);
            $post->setTitle($title);

            return $post;


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     *
     * ADD NEW POST
     *
     */
    public static function create($title, $content, $error)
    {

            $db = static::getDB();

            $stmt = $db->prepare("INSERT INTO posts (title, content, created_at) VALUES (:title, :content, NOW())");

            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);

            $results = $stmt->execute();

            return $results;

    }

    /*
    *
    * Update post
    *
    */
    public static function update($id, $title, $content)
    {

            $post = new Post();

            $post->setId($id);
            $post->setContent($content);
            $post->setTitle($title);


            $db = static::getDB();
            $stmt = $db->prepare("UPDATE posts SET title = :title, content = :content, created_at = NOW() WHERE id = :id");

            $id = $post->getId();
            $title = $post->getTitle();
            $content = $post->getContent();

            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);

            $results = $stmt->execute();

            return $results;
    }

    /*
     *
     * Delete post
     *
     */
    public static function delete($id)
    {


            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");

            $stmt->bindParam(':id', $id);

            $results = $stmt->execute();

            return $results;

    }

}