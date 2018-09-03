<?php

// session_start();

// utilities

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/db_connect.php';
// remove if downloading from repo
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/db_connect_local.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/tools.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/jwt.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/generic.php';
//still trying to figure out a way to break models out into objects
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/model.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/action.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/utilities/controller.php';

// asset

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/asset/asset_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/asset/asset_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/asset/asset_model.php';

// article 

// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/article/article_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/article/article_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/article/article_model.php';

// message

// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/message/message_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/message/message_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/message/group_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/message/message_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/message/user_has_group_model.php';

// post

// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/post/post_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/post/post_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/post/post_model.php';

// comment

// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/comment/comment_utilities.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/comment/comment_controller.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/comment/comment_model.php';

// user
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/user/user_utilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/user/user_controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/user/user_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/user/user_profile_image_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/user/user_profile_model.php';
