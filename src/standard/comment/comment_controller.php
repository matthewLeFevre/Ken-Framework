<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$comment = new Controller('comment');

// untested
$comment->addAction('createComment', function($payload){
    $filterLoad = Controller::filterPayload($payload);
    if(empty($filterLoad['userId'])||
       empty($filterLoad['articleId']) ||
       empty($filterLoad['commentBody']) ) {
           return Response::err();
           exit;
       }

    $createComment = create_comment($filterLoad);
    if($createComment == 1) {
        return Response::data(get_comments_by_articleId($filterLoad['articleId']));
    } else {
        return Resposne::err();
    }
});

// untested
$comment->addAction('updateComment', function($payload){
    $filterLoad = Controller::filterPayload($payload);
    if(empty($filterLoad['commentId']) ||
       empty($filterLoad['articleId']) ||
       empty($filterLoad['commentBody'])) {
        return Response::err();
        exit;
    }
    $updateComment = update_comment($filterLoad);
    if($createComment == 1) {
        return Response::data(get_comments_by_articleId($filterLoad['articleId']));
    } else {
        return Response::err();
    }
});

// untested
$comment->addAction('deleteComment', function($payload){
    $filterLoad = Controller::filterPayload($payload);
    if(empty($filterLoad['commentId']) ||
       empty($filterLoad["articleId"])) {
        return Response::err();
        exit;
    }
    $deleteComment = deleteComment($filterLoad['commentId']);
    if($deleteComment == 1) {
        return Response::data(get_comments_by_articleId($filterLoad['articleId']));
    } else {
        return Response::err();
    }
});

// untested
$comment->addAction('getCommentsByArticleId', function($payload){
    $filterLoad = Controller::filterPayload($payload);
    if(empty($filterLoad['commentId'])) {
        return Response::err();
    }
    $commentData = get_comments_by_articleId($filterLoad['articleId']);
    return Response::data($commentData);
});
