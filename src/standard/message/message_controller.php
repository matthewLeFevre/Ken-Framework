<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$message = new Controller('message');

// untested
$message->addAction('createMessage', 

    function($payload){
        $filterLoad = Controller::filterPayload($payload);
                      Controller::required(['messageBody','userId', 'groupId'], $filterLoad);
        
        $createMessage = create_message($filterLoad);
        
        if($createMessage == 1) {
            return Response::data(get_messages_by_group_id($filterLoad['groupId']), $messagesRetrieved);
        } else {
            return Response::err("message was not created");
        }
}, TRUE);

// untested
$message->addAction('assignMessage', 

    function($payload){

        $filterLoad = Controller::filterPayload($payload);
                      Controller::required(['messageId']);

}, TRUE);

// untested
$message->addAction('deleteMessage', function($payload){}, TRUE);
  
// untested
$message->addAction('getMessageById', function($payload){}, TRUE);

$message->addAction('createGroup', 

    function($payload){

        $filterLoad = Controller::filterPayload($payload);
                    Controller::required(['userId'], $filterLoad);
        
        if (!isset($filterLoad['groupTitle'])) {
            $filterLoad['groupTitle'] = "New Group";
        }

        $createGroup = create_group($filterLoad);

        // Assign the user to the group

        if($createGroup == 1) {
            $group = get_last_group_by_userId($userId);
            $createUserInGroup = create_user_group(['userId' => $filterLoad['userId'], 'groupId'=>$group['groupId']]);

            if($createUserInGroup == 1) {
                return Response::data(get_groups_by_userId($filterLoad['userId']), "group was created!");
            } else {
                return Response::err("group was created but you were not included in the group");
            }

        } else {
            return Response::err("group was not created");
        }

}, TRUE);

$message->addAction('addUserToGroup', 

    function($payload){
        
        $filterLoad = Controller::filterPayload($payload);
                    Controller::required(['userId', 'groupId'], $filterLoad);

        $createUserInGroup = create_user_group($filterLoad);

        if($createUserInGroup == 1) {
            return Response::data(get_groups_by_userId($userId), "user was added to group");
        } else {
            return Response::err("Error occured attempting to add user to group");
        }

}, TRUE);

$message->addAction('deleteGroup', 
    
    function($payload){

        $filterLoad = Controller::filterPayload($payload);
                      Controller::required(['userId', 'groupId'], $filterLoad);

        $deleteGroup = delete_group($filterLoad);

        if($deleteGroup == 1) {
            return Response::data(get_groups_by_userId($userId), "user was added to group");
        } else {
            return Response::err("Error occured attempting to add user to group");
        }
    }, TRUE);