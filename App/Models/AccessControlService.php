<?php

namespace App\Models;

use PDO;
use App\Models\Entity\RolePermission;
use App\Models\Entity\User;

class AccessControlService extends \Core\Model   {

    public static function isLoggedIn () {

        $user =  isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

        if ($user && $user->status == 1) {

            return $user;

        }

        return false;

    }


    public static function checkAccess () {

        $user = static::isLoggedIn();

        $role = static::RolePermissions($user->role_id);

        return true;
    }

    public static function RolePermissions ($role) {

        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT id, permission_id, module_id FROM roles_permissions  WHERE role_id = :role_id");
            $stmt->execute(["role_id"=>$role]);

            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            /* Create empty array for entites */
            $roles = [];

            /**
             * Check all posts - take value from array and put data array into Entity
             */

            foreach($results as $item) {

                $rolePermission = new RolePermission();

                $rolePermission->setId($results['id']);
                $rolePermission->setPermissionid($results['permission_id']);
                $rolePermission->setModuleid($results['module_id']);


                /* add entity to array */
                array_push($roles,  $rolePermission);
            }

            /* Return array of entities */
            return $roles;


        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

}