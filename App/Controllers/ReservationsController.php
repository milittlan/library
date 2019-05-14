<?php

namespace App\Controllers;

use App\Models\ReservationServices;
use App\Models\UserService;
use \Core\View;
use App\Models\BookService;

/**
 * Posts controller
 *
 * PHP version 5.4
 */
class ReservationsController extends \Core\Controller
{

    public function indexAction()
    {

        $reservationServices = new ReservationServices();
        $reservations = $reservationServices->readAll();

        /**
         * Render template for all users
         */

        View::renderTemplate('Reservations/index.html', [
            'reservations' => $reservations
        ]);

    }

    public function addNewAction()
    {
        $userServics = new UserService();
        $users = $userServics->readAll();

        $bookServices = new BookService();
        $books = $bookServices->readAll();

        /**
         * Checking is it post - create reservation in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userid   = $_POST['userid'];
            $bookid = $_POST['bookid'];

            $date = $_POST['datecreated'];
            $datecreated = date('Y-m-d H:i:s', strtotime(str_replace(" ","-",$_POST['datecreated'])));

            $dateendtest = $_POST['dateend'];
            $dateend = date("Y-m-d", strtotime($dateendtest));
            $description = $_POST['description'];
            $status = $_POST['status'];

            /**
             *
             * Validate description.
             * For testing we are checking does fields have exact content.
             *
             */
            if ($description == 'aaa') {
                $error_message = 'Greska - polje description ne moze dabude prazno';
                $this->addError($error_message);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $reservationService = new ReservationServices();

                    $reservation = $reservationService->create($userid, $bookid, $datecreated, $dateend, $description, $status);


                    /* Redirect to index/All posts page */
                    header('Location: index');


                }  catch (\PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             *
             * IF EROOR is not empty - Display forms with error message and content.
             *
             */

            View::renderTemplate('Reservations/addReservation.html', [
                'userid' => $userid,
                'bookid' => $bookid,
                'datecreated' => $datecreated,
                'dateend' => $dateend,
                'description' => $description,
                'status' => $status,
                'errors' => $this->getErrors()
            ]);
            return;
        }

        /**
         *
         * Render empty form when for action add new post
         */

        View::renderTemplate('Reservations/addReservation.html', [
            'users' => $users,
            'books' => $books
        ]);
        return;
    }

    /**
     * Edit action
     */

    public function editAction()
    {

        $id = $this->getRouteParams('id');

        $userServics = new UserService();
        $users = $userServics->readAll();

        $bookServices = new BookService();
        $books = $bookServices->readAll();

        /**
         * Checking is it POST - Take new content - Validate data - Update action
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id   = $_POST['id'];
            $userid   = $_POST['userid'];
            $bookid = $_POST['bookid'];
            $datecreated = $_POST['datecreated'];
            $dateend = $_POST['dateend'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            /**
             * ITs Reservation!
             * validation of updated content
             */

            if ($description == 'aaa') {
                $error_message = 'Greska - polje Description ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }



            /**
             * Check errors
             */

            if (empty($this->getErrors())) {

                try {

                    $reservationServices = new ReservationServices();

                    $reservation = $reservationServices->update($id, $userid, $bookid, $datecreated, $dateend, $description, $status);

                    /**
                     * Redirect to index/All posts page
                     */
                    header('Location: /Reservations/index');


                } catch (PDOException $e) {
                    $this->addError($e->getMessage());
                }

            }

            /**
             * Display forms with error message and content.
             */

            View::renderTemplate('Reservations/editReservation.html', [
                'id' => $id,
                'userid' => $userid,
                'bookid' => $bookid,
                'datecreated' => $datecreated,
                'dateend' => $dateend,
                'description' => $description,
                'status' => $status,
                'users' => $users,
                'errors' => $this->getErrors()
            ]);
            return;


        } else {

            /**
             * Its not PACKAGE and we render form with existing content
             */

            $reservationServices = new ReservationServices();
            $reservation = $reservationServices->readOne($id);

            $id = $reservation->getId();
            $userid = $reservation->getUserid();
            $bookid = $reservation->getBookid();
            $datecreated = $reservation->getDatecreated();
            $dateend = $reservation->getDateend();
            $description = $reservation->getDescription();
            $status = $reservation->getStatus();


            View::renderTemplate('Reservations/editReservation.html', [
                'id' => $id,
                'userid' => $userid,
                'bookid' => $bookid,
                'datecreated' => $datecreated,
                'dateend' => $dateend,
                'description' => $description,
                'users' => $users,
                'books' => $books,
                'status' => $status
            ]);
        }

    }

    /**
     * Delete action
     */

    public function deleteAction()
    {

        /* Take id from route */

        $id = $this->getRouteParams("id");


        /**
         * Check is it post - delete post
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $reservationServices = new ReservationServices();
                $reservation = $reservationServices->delete($id);

                /* Redirect to index/All posts page */

                header('Location: /reservations/index');


            } catch (PDOException $e) {
                $this->addError($e->getMessage());
            }
        }

    }

    
}
