<?php

namespace App\Models;

use PDO;
use App\Models\Entity\Reservation;

/**
 * Post service (We rename this into SERVICE instead MODEL)
 */

class ReservationServices extends \Core\Model   {

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

        $stmt = $db->query('SELECT id, user_id, book_id, date_created, date_end, description, status FROM reservation ORDER BY id');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* Create empty array for entites */
        $reservations = [];


        /**
         * Check all posts - take value from array and put data array into Entity
         */

        foreach($results as $item) {

            $userReservations = new UserService();
            $bookReservations = new BookService();

            $reservation = new Reservation();

            $reservation->setId($item['id']);

            $reservation->setUserid($item['user_id']);

            $userReservation = $userReservations->readOne($item['user_id']);
            $reservation->setUserid($userReservation->getFirstname());

            $bookReservation = $bookReservations->readOne($item['book_id']);
            $reservation->setBookid($bookReservation->getTitle());

            $reservation->setDatecreated($item['date_created']);
            $reservation->setDateend($item ['date_end']);
            $reservation->setDescription($item ['description']);
            $reservation->setStatus($item['status']);

            /* add entity to array */
            array_push($reservations,  $reservation);
        }


        /* Return array of entities */
        return $reservations;

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

        $stmt = $db->prepare("SELECT * FROM reservation WHERE id = :id LIMIT 1");
        $stmt->execute(["id"=>$id]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);


        /**
         * Take value from array and put data array into Entity
         */

        $userReservations = new UserService();
        $bookReservations = new BookService();

        $reservation = new Reservation();

        $reservation->setId($results['id']);


        $userReservation = $userReservations->readOne($results['user_id']);
        $reservation->setUserid($userReservation);


        $bookReservation = $bookReservations->readOne($results['book_id']);
        $reservation->setBookid($bookReservation);

        $reservation->setDatecreated($results['date_created']);
        $reservation->setDateend($results['date_end']);
        $reservation->setDescription($results['description']);
        $reservation->setStatus($results['status']);


        /* Return Entity */

        return $reservation;


    }

    /**
     * @param $title
     * @param $content
     * @return mixed
     */
    public function create($userid, $bookid, $datecreated, $dateend, $description, $status)
    {

        $reservation = new Reservation();

        $reservation->setUserid($userid);
        $reservation->setBookid($bookid);
        $reservation->setDatecreated($datecreated);
        $reservation->setDateend($dateend);
        $reservation->setDescription($description);
        $reservation->setStatus($status);

        /**
         * DB connection
         */

        $db = static::getDB();


        /*
         * Query - Insert post into database
         */

        $stmt = $db->prepare("INSERT INTO reservation (user_id, book_id, date_created, date_end, description, status) VALUES (:user_id, :book_id, :date_created, :date_end, :description, :status)");

        $userid = $reservation->getUserid();
        $bookid = $reservation->getBookid();
        $datecreated = $reservation->getDatecreated();
        $dateend = $reservation->getDateend();
        $description = $reservation->getDescription();
        $status = $reservation->getStatus();

        $stmt->bindParam(':user_id', $userid, PDO::PARAM_STR);
        $stmt->bindParam(':book_id', $bookid, PDO::PARAM_STR);
        $stmt->bindParam(':date_created', $datecreated, PDO::PARAM_STR);
        $stmt->bindParam(':date_end', $dateend, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
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
     * @param $title
     * @param $content
     * @return bool
     */
    public function update($id, $userid, $bookid, $datecreated, $dateend, $description, $status)
    {
        /**
         * Take existing value from post
         */

        $reservation = new Reservation();

        $reservation->setId($id);
        $reservation->setUserid($userid);
        $reservation->setBookid($bookid);
        $reservation->setDatecreated($datecreated);
        $reservation->setDateend($dateend);
        $reservation->setDescription($description);
        $reservation->setStatus($status);


        /* DB connection */

        $db = static::getDB();


        /*
         * Query - Update posts
         */

        $stmt = $db->prepare("UPDATE reservation SET user_id = :user_id, book_id = :book_id, date_created = :date_created, date_end = :date_end, description = :description, status = :status WHERE id = :id");

        $id = $reservation->getId();
        $userid = $reservation->getUserid();
        $bookid = $reservation->getBookid();
        $datecreated = $reservation->getDatecreated();
        $dateend = $reservation->getDateend();
        $description = $reservation->getDescription();
        $status = $reservation->getStatus();

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userid, PDO::PARAM_STR);
        $stmt->bindParam(':book_id', $bookid, PDO::PARAM_STR);
        $stmt->bindParam(':date_created', $datecreated, PDO::PARAM_STR);
        $stmt->bindParam(':date_end', $dateend, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
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
        $reservation = new Reservation();

        $reservation->setId($id);

        /* DB connection */

        $db = static::getDB();


        /*
        * Query - Delete post
        */

        $stmt = $db->prepare("DELETE FROM reservation WHERE id = :id");

        $id = $reservation->getId();

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