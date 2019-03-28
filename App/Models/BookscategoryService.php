<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Category;

/**
 * Book category model
 */
class BookscategoryService extends \Core\Model {


    /**
     * Get all the categories as an array (array of Entities)
     *
     * @return array
     */
    public function readAll()
    {
        /* DB connection */
        $db = static::getDB();


        /*
         * Query - Select all categories from database
         */

        $stmt = $db->query('SELECT id, parent_id, level, name, alias FROM books_category ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $categories = [];


        /**
         * Check all categories - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $id = $item['id'];
            $parent_id = $item['parent_id'];
            $level = $item['level'];
            $name = $item['name'];
            $alias = $item['alias'];

            $category = new Category();

            $category->setId($id);
            $category->setParentId($parent_id);
            $category->setLevel($level);
            $category->setName($name);
            $category->setAlias($alias);

            /* add entity to array */
            array_push($categories,  $category);
        }


        /* Return array of entities */
        return $categories;

    }


    /**
     * @param $id
     * @return Category
     *
     */
    public function readOne($id){

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all categories from database
         */

        $stmt = $db->prepare("SELECT * FROM books_category WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $id = $results['id'];
        $parent_id = $results['parent_id'];
        $level = $results['level'];
        $name = $results['name'];
        $alias = $results['alias'];

        $category = new Category();

        $category->setId($id);
        $category->setParentId($parent_id);
        $category->setLevel($level);
        $category->setName($name);
        $category->setAlias($alias);


        /* Return Entity */

        return $category;

    }

    public function readAllCategories()
    {
        /* DB connection */
        $db = static::getDB();


        /*
         * Query - Select all categories from database
         */

        $stmt = $db->query('SELECT id, parent_id, level, name, alias FROM books_category ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $categories = [];


        /**
         * Check all categories - take value from array and put data array into Entity
         */

        foreach($results as $item) {


            $name = $item['name'];
            $id = $item['id'];

            $category = new Category();

            $category->setName($name);
            $category->setId($id);


            /* add entity to array */
            array_push($categories,  $category);
        }


        /* Return array of entities */
        return $categories;

    }


    /**
     * @param $parent_id
     * @param $level
     * @param $name
     * @param $alias
     * @return bool
     */
    public function create ($parent_id, $level, $name, $alias)
    {

        $category = new Category();


        $category->setParentId($parent_id);
        $category->setLevel($level);
        $category->setName($name);
        $category->setAlias($alias);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Select all categories from database
         */

        $stmt = $db->prepare("INSERT INTO books_category (parent_id, level, name, alias) VALUES (:parent_id, :level, :name, :alias)");

        $parent_id = $category->getParentId();
        $level = $category->getLevel();
        $name = $category->getName();
        $alias = $category->getAlias();

        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_STR);
        $stmt->bindParam(':level', $level, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);

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
     * @param $parent_id
     * @param $level
     * @param $name
     * @param $alias
     * @return bool
     */
    public function update($id, $parent_id, $level, $name, $alias)
    {
        /**
         * Take existing value from categories
         */

        $category = new Category();

        $category->setId($id);
        $category->setParentId($parent_id);
        $category->setLevel($level);
        $category->setName($name);
        $category->setAlias($alias);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update category
         */

        $stmt = $db->prepare("UPDATE books_category SET parent_id = :parent_id, level = :level, name = :name, alias = :alias WHERE id = :id");

        $id = $category->getId();
        $parent_id = $category->getParentId();
        $level = $category->getLevel();
        $name = $category->getName();
        $alias = $category->getAlias();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_STR);
        $stmt->bindParam(':level', $level, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);

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

        $category = new Category();

        $category->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete category
        */

        $stmt = $db->prepare("DELETE FROM books_category WHERE id = :id");

        $id = $category->getId();

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