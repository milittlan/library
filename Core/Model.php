<?php

namespace Core;

use PDO;
use App\Config;
/**
 * Base model
 *
 */
abstract class Model {

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            /**
             * We disable this code because we defined db connection in  Config.php
             *
             */

            //$host = 'localhost';
            //$dbname = 'milanbil_mvc';
            //$username = 'milanbil_mvc';
            //$password = 'oaD)2X^Bq&bR';

            //try {
                //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                //              $username, $password);
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' .
                    Config::DB_NAME . ';charset=utf8';
                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $db;

        }


    }
}
