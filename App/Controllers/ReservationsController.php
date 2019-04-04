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
         * Checking is it post - create post in database - redirect to index
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $firstname   = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $roleid = $_POST['roleid'];
            $status = $_POST['status'];

            /**
             *
             * Validate title and content.
             * For testing we are checking does fields have exact content.
             *
             */
            if ($firstname == 'aaa') {
                $error_message = 'Greska - polje Name ne moze da ima ovaj sadrzaj';
                $this->addError($error_message);
            }

            /**
             * IF empty errors
             */

            if (empty($this->getErrors())) {

                try {

                    $userServics = new UserService();

                    $user = $userServics->create($firstname, $lastname, $email, $roleid, $status);


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

            View::renderTemplate('Users/addUser.html', [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'roleid' => $roleid,
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

    
}
