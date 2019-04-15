<?php

namespace App\Models;

use App\Models\Entity\Permission;
use PDO;
use App\Models\Entity\Module;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class PermissionService extends \Core\Model   {

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

        $stmt = $db->query('SELECT id, permission, module_id FROM permissions ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $permissions = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $permission = new Permission();

            $permission->setId($item['id']);
            $permission->setName($item['permission']);
            $permission->setModule($item['module_id']);

            /* add entity to array */
            array_push($permissions,  $permission);
        }


        /* Return array of entities */
        return $permissions;

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

        $stmt = $db->prepare("SELECT * FROM permissions WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $modules = new ModuleService();

        $permission = new Permission();

        $permission->setId($results['id']);
        $permission->setName($results['permission']);
        $permission->setModule($results['module_id']);

        $module = $modules->readOne($results['module_id']);
        $permission->setModule($module->getName());



        /* Return Entity */

        return $permission;

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
    public function create($name, $module)
    {

        $permission = new Permission();

        $permission->setName($name);
        $permission->setModule($module);


        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all books from database
         */

        $stmt = $db->prepare("INSERT INTO permissions (permission, module_id) VALUES (:name, :module)");


        $name = $permission->getName();
        $module = $permission->getModule();



        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':module', $module, PDO::PARAM_STR);


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

    public function update ($id, $name, $module)
    {

        /**
         * Take existing value from Book
         */

        $permission = new Permission();

        $permission->setId($id);
        $permission->setName($name);
        $permission->setModule($module);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update book
         */

        $stmt = $db->prepare("UPDATE permissions SET permission = :name, module_id = :module WHERE id = :id");

        $id = $permission->getId();
        $name = $permission->getName();
        $module = $permission->getModule();


        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':module', $module, PDO::PARAM_STR);


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