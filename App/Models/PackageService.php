<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Package;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class PackageService extends \Core\Model   {

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

        $stmt = $db->query('SELECT id, name, value, duration, user_id FROM packages ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $packages = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $id = $item['id'];
            $name = $item['name'];
            $value = $item['value'];
            $duration = $item['duration'];
            $user_id = $item['user_id'];

            $package = new Package();

            $package->setId($id);
            $package->setName($name);
            $package->setValue($value);
            $package->setDuration($duration);
            $package->setUserId($user_id);


            /* add entity to array */
            array_push($packages,  $package);
        }


        /* Return array of entities */
        return $packages;

    }

    /**
     * @param $id
     * @return Package
     */
    public function readOne($id){

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all posts from database
         */

        $stmt = $db->prepare("SELECT * FROM packages WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $id = $results['id'];
        $name = $results['name'];
        $value = $results['value'];
        $duration = $results['duration'];
        $user_id = $results['user_id'];

        $package = new Package();

        $package->setId($id);
        $package->setName($name);
        $package->setValue($value);
        $package->setDuration($duration);
        $package->setUserId($user_id);


        /* Return Entity */

        return $package;


    }

    /**
     * @param $name
     * @param $value
     * @param $duration
     * @param $user_id
     * @return bool
     *
     */
    public function create($name, $value, $duration, $user_id)
    {

        $package = new Package();

        $package->setName($name);
        $package->setValue($value);
        $package->setDuration($duration);
        $package->setUserId($user_id);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert package into database
         */

        $stmt = $db->prepare("INSERT INTO packages (name, value, duration, user_id) VALUES (:name, :value, :duration, :userid)");

        $name = $package->getName();
        $value = $package->getValue();
        $duration = $package->getDuration();
        $user_id = $package->getUserId();

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_STR);
        $stmt->bindParam(':userid', $user_id, PDO::PARAM_STR);

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
     * @param $value
     * @param $duration
     * @param $user_id
     * @return bool
     */
    public function update($id, $name, $value, $duration, $user_id)
    {
        /**
         * Take existing value from post
         */

        $package = new Package();

        $package->setId($id);
        $package->setName($name);
        $package->setValue($value);
        $package->setDuration($duration);
        $package->setUserId($user_id);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update packages
         */

        $stmt = $db->prepare("UPDATE packages SET name = :name, value = :value, duration = :duration, user_id = :userid WHERE id = :id");

        $id = $package->getId();
        $name = $package->getName();
        $value = $package->getValue();
        $duration = $package->getDuration();
        $user_id = $package->getUserId();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_STR);
        $stmt->bindParam(':userid', $user_id, PDO::PARAM_STR);

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
        $package = new Package();

        $package->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete package
        */

        $stmt = $db->prepare("DELETE FROM packages WHERE id = :id");

        $id = $package->getId();

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