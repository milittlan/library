<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Post;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class PostService extends \Core\Model {

    /**
     * Get all the posts as an array (array of Entities)
     *
     * @return array
     */
    public static function readAll()
    {
        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all posts from database
         */

        $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /**
         * Create empty array for entites
         */

        $posts = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $id = $item['id'];
            $title = $item['title'];
            $content = $item['content'];

            $post = new Post();

            $post->setId($id);
            $post->setContent($content);
            $post->setTitle($title);

            /**
             * add entity to array
             */
            array_push($posts,  $post);
        }


        /**
         * Return array of entities
         */

        return $posts;

    }

    /**
     * @param $id
     * @return Post
     *
     */
    public static function readOne($id){

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all posts from database
         */

        $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $id = $results['id'];
        $title = $results['title'];
        $content = $results['content'];

        $post = new Post();

        $post->setId($id);
        $post->setContent($content);
        $post->setTitle($title);


        /**
         * Return Entity
         */

        return $post;


    }

    /**
     * @param $title
     * @param $content
     * @return mixed
     */
    public static function create($title, $content)
    {

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all posts from database
         */

        $stmt = $db->prepare("INSERT INTO posts (title, content, created_at) VALUES (:title, :content, NOW())");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

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
     * @param $content
     * @return bool
     */
    public static function update($id, $title, $content)
    {
        /**
         * Take existing value from post
         */

        $post = new Post();

        $post->setId($id);
        $post->setContent($content);
        $post->setTitle($title);


        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Update posts
         */

        $stmt = $db->prepare("UPDATE posts SET title = :title, content = :content, created_at = NOW() WHERE id = :id");

        $id = $post->getId();
        $title = $post->getTitle();
        $content = $post->getContent();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

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
     */
    public static function delete($id)
    {

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
        * Query - Delete post
        */

        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $id);

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