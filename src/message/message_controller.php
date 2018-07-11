<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$message = new Controller('message');

// untested
$message->addAction('createMessage', function($payload){});

// untested
$message->addAction('assignMessage', function($payload){});

// untested
$message->addAction('deleteMessage', function($payload){});
  
// untested
$message->addAction('getMessageById', function($payload){});