<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$comment = new Controller('comment');

// untested
$comment->addAction('createComment', function($payload){});

// untested
$comment->addAction('updateComment', function($payload){});

// untested
$comment->addAction('assignComment', function($payload){});

// untested
$comment->addAction('deleteComment', function($payload){});

// untested