<?php

namespace App;

/**
 * Application configuration
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'library';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     *
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     *
     * ADDITIONAl - If we put false all errors will be written in logs folder in file named by date.
     */
    const SHOW_ERRORS = true;
}
