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

$message->addAction('createGroup', function($payload){
    $filterLoad = Controller::filterPayload($payload);
    if(empty($filterLoad['userId']) {
        return Response::err("Required data was not present in request");
        exit;
    }

    $createGroup = create_group($filterLoad);
    if($createGroup == 1) {
        return Response::data(get_groups_by_userId($filterLoad['userId']), "group was created!");
    } else {
        return Response::err("group was not created");
    }
});