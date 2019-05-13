<?php

namespace App\Models;

use PDO;
use App\Models\Entity\User;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class UserService extends \Core\Model   {

    /**
     * Get all the users as an array (array of Entities)
     *
     * @return array
     */
    public function readAll()
    {
        /* DB connection */
        $db = static::getDB();


        /*
         * Query - Select all users from database
         */

        $stmt = $db->query('SELECT id, firstname, lastname, email, role_id, package_id, status FROM user ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $users = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $RoleService = new RoleService();
            $packageServices = new PackageService();


            $user = new User();

            $user->setId($item['id']);
            $user->setFirstname( $item['firstname']);
            $user->setLastname( $item['lastname']);
            $user->setEmail($item['email']);

            $user->setRole($item['role_id']);
            $user->setPackage($item['package_id']);

            $userRole = $RoleService->readOne($item['role_id']);
            $user->setRole($userRole->getName());

            $packageUser = $packageServices->readOne($item['package_id']);
            $user->setPackage($packageUser->getName());

            $user->setStatus($item['status']);

            /* add entity to array */
            array_push($users,  $user);
        }


        /* Return array of entities */
        return $users;

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

        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $Roleservices = new RoleService();
        $packageServices = new PackageService();

        $user = new User();


        $user->setId($results['id']);
        $user->setFirstname($results['firstname']);
        $user->setLastname($results['lastname']);
        $user->setEmail($results['email']);
        $user->setPassword($results['password']);

        $userRole = $Roleservices->readOne($results['role_id']);
        $user->setRole($userRole);

        $userPackage = $packageServices->readOne($results['package_id']);
        $user->setPackage($userPackage);

        $user->setStatus($results['status']);

        /* Return Entity */

        return $user;


    }

    /**
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $password
     * @param $role_id
     * @param $status
     * @return bool
     */
    public function create ($firstname, $lastname, $email, $hashpassword, $role, $package, $status)
    {

        $user = new User();

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($hashpassword);
        $user->setRole($role);
        $user->setPackage($package);
        $user->setStatus($status);


        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert user into database
         */

        $stmt = $db->prepare("INSERT INTO user (firstname, lastname, email, password, role_id, package_id, status) VALUES (:firstname, :lastname, :email, :password, :role_id, :package_id, :status)");

        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $hashpassword = $user->getPassword();
        $role = $user->getRole();
        $package = $user->getPackage();
        $status = $user->getStatus();

        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashpassword, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role, PDO::PARAM_STR);
        $stmt->bindParam(':package_id', $package, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

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
    public function update ($id, $firstname, $lastname, $email, $hashpassword, $role, $package, $status)
    {
        /**
         * Take existing value from post
         */

        $user = new User();

        $user->setId($id);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($hashpassword);
        $user->setRole($role);
        $user->setPackage($package);
        $user->setStatus($status);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update posts
         */

        $stmt = $db->prepare("UPDATE user SET id = :id, firstname = :firstname, lastname = :lastname, email = :email, password = :password, role_id = :role_id, package_id = :package_id, status = :status WHERE id = :id");

        $id = $user->getId();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $hashpassword = $user->getPassword();
        $role = $user->getRole();
        $package = $user->getPackage();
        $status = $user->getStatus();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashpassword, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role, PDO::PARAM_STR);
        $stmt->bindParam(':package_id', $package, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

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
        $user = new User();

        $user->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete post
        */

        $stmt = $db->prepare("DELETE FROM user WHERE id = :id");

        $id = $user->getId();

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

    public function register ($firstname, $lastname, $email, $hashpassword, $role, $package, $status) {

        $user = new User();

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($hashpassword);
        $user->setRole($role);
        $user->setPackage($package);
        $user->setStatus($status);


        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert user into database
         */

        $stmt = $db->prepare("INSERT INTO user (firstname, lastname, email, password, role_id, package_id, status) VALUES (:firstname, :lastname, :email, :password, :role_id, :package_id, :status)");

        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $hashpassword = $user->getPassword();
        $role = $user->getRole();
        $package = $user->getPackage();
        $status = $user->getStatus();

        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashpassword, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role, PDO::PARAM_STR);
        $stmt->bindParam(':package_id', $package, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

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

    public function login ($email, $hashpassword) {

    }

    public function isLoggedIn () {

    }

    public function approve () {

    }

}