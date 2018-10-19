<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$post = new Controller('post');


// untested
$post->addAction('createPost', function($payload){});

// untested
$post->addAction('updatePost', function($payload){});

// untested
$post->addAction('deletePost', function($payload){});

// untested
$post->addAction('assignPost', function($payload){});

// untested
$post->addAction('getPostById', function($payload){});

// untested
$post->addAction('getPostByUserId', function($payload){});

// untested
$post->addAction('getPostsByAssignment', function($payload){});