<?php

// utilities

/**
 *  Configure this db_connect file to connect to the database you have
 *  created.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/db_connect.php';

/**
 * This db_connect_local is the file used locally for development
 * of php generic and can be deleted if downloading from github.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/db_connect_local.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/response.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/jwt.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/ken.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/action.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/dispatcher.php';

// Account
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/features/Account/utilities_account.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/features/Account/controller_account.php';