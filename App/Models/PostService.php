<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Post;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class PostService extends \Core\Model   {

    /**
     * Get all the posts as an array (array of Entities)
     *
     * @return array
     */
    public function readAll()
    {
        /* DB connection */
        $db = static::getDB();


        /*
         * Query - Select all posts from database
         */

        $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $posts = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $post = new Post();

            $post->setId($item['id']);
            $post->setContent($item['title']);
            $post->setTitle($item['content']);

            /* add entity to array */
            array_push($posts,  $post);
        }


        /* Return array of entities */
        return $posts;

    }

    /**
     * @param $id
     * @return Post
     *
     */
    public function readOne($id){

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

        $post = new Post();

        $post->setId($results['id']);
        $post->setContent($results['title']);
        $post->setTitle($results['content']);


        /* Return Entity */

        return $post;

    }

    /**
     * @param $title
     * @param $content
     * @return mixed
     */
    public function create($title, $content)
    {

        $post = new Post();

        $post->setTitle($title);
        $post->setContent($content);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert post into database
         */

        $stmt = $db->prepare("INSERT INTO posts (title, content, created_at) VALUES (:title, :content, NOW())");

        $title = $post->getTitle();
        $content = $post->getContent();

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
    public function update($id, $title, $content)
    {
        /**
         * Take existing value from post
         */

        $post = new Post();

        $post->setId($id);
        $post->setContent($content);
        $post->setTitle($title);


        /* DB connection */

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
    public function delete($id)
    {
        $post = new Post();

        $post->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete post
        */

        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");

        $id = $post->getId();

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