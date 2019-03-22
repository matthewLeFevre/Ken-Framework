<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$article = new Controller('article');

// Create Article -- passing
$article->addAction('createArticle', function($payload) {
  $filterLoad = Controller::filterPayload($payload, 'articleBody');
  $filterLoad['articleBody'] = Controller::filterHTML($filterLoad['articleBody']);
                               Controller::required(['articleTitle', 'articleStatus', 'userId', 'articleBody', 'articleLink'], $filterLoad);

  // stores article in db
  $createNewArticle = create_new_article($filterLoad);

  // send success or failure message to client
  if($createNewArticle == 1) {
    return Response::success($filteredPayload['articleTitle'] . " was successfully created");
  } else {
    return Response::err($filterLoad['articleTitle'] . " was not successfully created.");
  }
}, TRUE);

// Update Article -- passing
$article->addAction('updateArticle', function($payload) {
  $filterLoad = Controller::filterPayload($payload, 'articleBody');
  $filterLoad['articleBody'] = Controller::filterHTML($filterLoad['articleBody']);
                Controller::required(['articleTitle', 'articleBody', 'articleStatus', 'articleModified', 'topicId', 'userId'], $payload);
  $updateArticle = update_article($filterLoad);

  // send success or failure message to client
  if($updateArticle) {
    return response("success", $filterLoad['articleTitle'] . " was successfully updated");
  } else {
    return response("failure", $filterLoad['articleTitle'] . " was not successfully updated.");
  }
}, TRUE);

// Update Article Status -- passing
$article->addAction('updateArticleStatus', function($payload) {
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['articleId', 'userId', 'articleStatus'], $filterLoad);
  $filterLoad['articleModified'] = date('Y-m-d H:i:s');

  // updates article status
  // updates article in db
  $updateArticleStatus = update_article_status($filterLoad);

  // send success or failure message to client
  if($updateArticleStatus == 1) {
    return Response::data(get_articles_by_userId($filterLoad['userId']),"Article was successfully " . $filterLoad['articleStatus']);
  } else {
    return Response::err("Article was not successfully " . $filterLoad['articleStatus']);
  }
}, TRUE);

// Delete Article -- passing
$article->addAction('deleteArticle', function($payload) {
  $filterLoad = Controller::filterPayload($payload);
                     Controller::required(['articleId', 'userId'], $filterLoad);

  // deletes article
  $deleteArticle = delete_article($filterLoad['articleId']);

  if($deleteArticle == 1) {
    return Response::data(get_articles_by_userId($filterLoad['userId']),"Article deleted successfully.");
  } else {
    return Response::err("Article was not deleted successfully.");
  }
}, TRUE);

// Get Article By ID -- passing
$article->addAction('getArticleById', function($payload) {
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['articleId'], $payload);

  $articleData = get_article_by_id($filterLoad['articleId']);
  return Response::data($articleData, "Article was retrieved successfully.");
});

// untested
$article->addAction('getPublishedArticleById', function($payload){
  $filterLoad = Controller::filterPayload($payload);
                Controller::required(['articleId'], $payload);

  $articleData = get_published_article_by_id($filterLoad['articleId']);
  return Response::data($articleData, "Article was retrieved successfully.");
});

// Get Article By Title -- untested
$article->addAction('getArticleByTitle', function($payload) {
  $filteredPayload = array();
  $filteredPayload['articleTitle'] = filter_var($payload['articleTitle'], FILTER_SANITIZE_STRING);

  if (empty($filteredPayload['articleTitle'])) {
    // empty input error
    return response("failure", "No articleTitle was specified.");
    exit;
  }

  $articleData = get_article_by_title($filteredPayload['articleTitle']);
  return dataResp("success", $articleData, "article was retrieved successfully.");
});

// Get Articles passing
$article->addAction('getArticles', function($payload) {
  $articles = get_articles();
  return dataResp("success", $articles, "All articles we retrieved.");
});

// untested
$article->addAction('getPublishedArticles', function($payload){
  $articles = get_published_articles();
  return dataResp("success", $articles, "All published articles were retrieved.");
});

// untested
$article->addAction('getArticlesByUserId', function($payload) {
  $userId = filter_var($payload['userId'], FILTER_SANITIZE_NUMBER_INT);
  $articles = get_articles_by_userId($userId);
  return dataResp("success", $articles, "All articles were retrieved.");
}, TRUE);

// Get Specified Number of Articles -- passing
$article->addAction('getNumberOfArticles', function($payload) {
  $numArticles = filter_var($payload['articleNumber'], FILTER_SANITIZE_NUMBER_INT);
  $articles = get_number_of_articles($numArticles);
  return dataResp("success", $articles, "Articles were retrieved successfully");
});

// untested
$article->addAction('getNumberOfPublishedArticles', function($payload){
  $numArticles = filter_var($payload['articleNumber'], FILTER_SANITIZE_NUMBER_INT);
  $articles = get_number_of_published_articles($numArticles);
  return dataResp("success", $articles, "Published articles were retrieved successfully");
});