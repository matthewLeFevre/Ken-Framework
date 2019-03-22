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

// asset

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/asset/asset_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/asset/asset_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/asset/asset_model.php';

// article 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/article/article_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/article/article_model.php';

// post

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/post/post_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/post/post_model.php';

// user
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/user/user_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/user/user_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/user/user_model.php';

// message
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/message/message_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/message/message_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/message/group_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/standard/message/user_has_group_model.php';
