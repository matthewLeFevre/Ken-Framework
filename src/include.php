<?php

// utilities
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Alter the directory path to where you store your .env file preferably
 * outside of the site root
 */
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

/**
 *  Configure this dbConnect file to connect to the database you have
 *  created.
 */

// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/dbConnect.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/response.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/jwt.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/ken.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/route.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/controller.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/dispatcher.php';

// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core/test/controller.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core/account/controller.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core/account/endpoints.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core/account/model.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core/account/seed.php';
