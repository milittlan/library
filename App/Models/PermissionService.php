<?php

namespace App\Models;

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

        $stmt = $db->query('SELECT id, name FROM module ORDER BY id');
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

            /* add entity to array */
            array_push($modules,  $module);
        }


        /* Return array of entities */
        return $modules;

    }


}