<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Role;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class RoleService extends \Core\Model   {

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

        $stmt = $db->query('SELECT id, name, description FROM roles ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $roles = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $id = $item['id'];
            $name = $item['name'];
            $description = $item['description'];

            $role = new Role();

            $role->setId($id);
            $role->setName($name);
            $role->setDescription($description);

            /* add entity to array */
            array_push($roles,  $role);
        }


        /* Return array of entities */
        return $roles;

    }

    /**
     * @param $id
     * @return Role
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

        $stmt = $db->prepare("SELECT * FROM roles WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $id = $results['id'];
        $name = $results['name'];
        $description = $results['description'];

        $role = new Role();

        $role->setId($id);
        $role->setName($name);
        $role->setDescription($description);


        /* Return Entity */

        return $role;


    }

    /**
     * @param $title
     * @param $content
     * @return mixed
     */
    public function create($name, $description)
    {

        $role = new Role();

        $role->setName($name);
        $role->setDescription($description);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert post into database
         */

        $stmt = $db->prepare("INSERT INTO roles (name, description) VALUES (:name, :description)");

        $name = $role->getName();
        $description = $role->getDescription();

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

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
     * @param $name
     * @param $description
     * @return bool
     */
    public function update($id, $name, $description)
    {
        /**
         * Take existing value from post
         */

        $role = new Role();

        $role->setId($id);
        $role->setName($name);
        $role->setDescription($description);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update posts
         */

        $stmt = $db->prepare("UPDATE roles SET name = :name, description = :description WHERE id = :id");

        $id = $role->getId();
        $name = $role->getName();
        $description = $role->getDescription();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

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
        $role = new Role();

        $role->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete post
        */

        $stmt = $db->prepare("DELETE FROM roles WHERE id = :id");

        $id = $role->getId();

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