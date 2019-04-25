<?php

namespace App\Models;

use App\Models\Entity\RolePermission;
use PDO;
use App\Models\Entity\Role;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class RolePermissionService extends \Core\Model   {

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

        $stmt = $db->query('SELECT id, role_id, permission_id, module_id FROM roles_permissions ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $rolesPermissions = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $permissions = new PermissionService();
            $roles = new RoleService();
            $modules = new ModuleService();

            $rolePermission = new RolePermission();

            $rolePermission->setId($item['id']);

            $permission = $permissions->readOne($item['permission_id']);
            $rolePermission->setPermissionid($permission);

            $role = $roles->readOne($item['role_id']);
            $rolePermission->setRoleid($role);

            $module = $modules->readOne($item['module_id']);
            $rolePermission->setModuleid($module);


            /* add entity to array */
            array_push($rolesPermissions,  $rolePermission);
        }


        /* Return array of entities */
        return $rolesPermissions;

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

        $role = new Role();

        $role->setId($results['id']);
        $role->setName($results['name']);
        $role->setMachinename($results['machine_name']);
        $role->setDescription($results['description']);


        /* Return Entity */

        return $role;

    }

    /**
     * @param $roleid
     * @param $permissionid
     * @return bool
     */
    public function create($roleid, $permissionid)
    {

        $rolePermission = new RolePermission();

        $rolePermission->setRoleId($roleid);
        $rolePermission->setPermissionId($permissionid);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert post into database
         */

        $stmt = $db->prepare("INSERT INTO roles_permissions (role_id, permission_id) VALUES (:roleid, :permissionid)");

        $roleid = $rolePermission->getRoleId();
        $permission_id = $rolePermission->getPermissionId();

        $stmt->bindParam(':roleid', $roleid, PDO::PARAM_STR);
        $stmt->bindParam(':permissionid', $permission_id, PDO::PARAM_STR);


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
    public function update($id, $name, $machinename, $description)
    {
        /**
         * Take existing value from post
         */

        $role = new Role();

        $role->setId($id);
        $role->setName($name);
        $role->setMachinename($machinename);
        $role->setDescription($description);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update posts
         */

        $stmt = $db->prepare("UPDATE roles SET name = :name, machine_name = :machinename, description = :description WHERE id = :id");

        $id = $role->getId();
        $name = $role->getName();
        $description = $role->getDescription();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':machinename', $machinename, PDO::PARAM_STR);
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