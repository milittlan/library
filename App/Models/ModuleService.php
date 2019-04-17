<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Module;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class ModuleService extends \Core\Model   {

    /**
     * Get all the modules as an array (array of Entities)
     *
     * @return array
     */
    public function readAll()
    {
        /* DB connection */
        $db = static::getDB();


        /*
         * Query - Select all modules from database
         */

        $stmt = $db->query('SELECT id, name, machine_name FROM module ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $modules = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $module = new Module();

            $module->setId($item['id']);
            $module->setName($item['name']);
            $module->setMachinename($item['machine_name']);

            /* add entity to array */
            array_push($modules,  $module);
        }


        /* Return array of entities */
        return $modules;

    }

    /**
     * @param $id
     * @return Module
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

        $stmt = $db->prepare("SELECT * FROM module WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $module = new Module();

        $module->setId($results['id']);
        $module->setName($results['name']);
        $module->setMachinename($results['machine_name']);



        /* Return Entity */

        return $module;

    }

    /**
     * @param $title
     * @param $content
     * @return mixed
     */
    public function create($name, $machinename)
    {

        $module = new Module();

        $module->setName($name);
        $module->setMachinename($machinename);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert post into database
         */

        $stmt = $db->prepare("INSERT INTO module (name, machine_name) VALUES (:name, :machinename)");

        $name = $module->getName();
        $machinename = $module->getMachinename();


        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':machinename', $machinename, PDO::PARAM_STR);

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
    public function update($id, $name, $machinename)
    {
        /**
         * Take existing value from post
         */

        $module = new Module();

        $module->setId($id);
        $module->setName($name);
        $module->setMachinename($machinename);

        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update posts
         */

        $stmt = $db->prepare("UPDATE module SET name = :name, machine_name = :machinename WHERE id = :id");

        $id = $module->getId();
        $name = $module->getName();
        $machinename = $module->getMachinename();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':machinename', $machinename, PDO::PARAM_STR);

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
        $module = new Module();

        $module->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete post
        */

        $stmt = $db->prepare("DELETE FROM module WHERE id = :id");

        $id = $module->getId();

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