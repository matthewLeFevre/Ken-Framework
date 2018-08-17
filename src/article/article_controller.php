<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

$article = new Controller('article');

// Create Article -- passing
$article->addAction('createArticle', function($payload) {
  // Copy the array to not mutate the data
  // of the original
  $filteredPayload = array();
  $filteredPayload['articleTitle']   = filter_var($payload['articleTitle'],  FILTER_SANITIZE_STRING);
  $filteredPayload['articleSummary'] = filter_var($payload['articleSummary'],FILTER_SANITIZE_STRING);
  $filteredPayload['articleBody']    = filter_var($payload['articleBody'],   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $filteredPayload['articleStatus']  = filter_var($payload['articleStatus'], FILTER_SANITIZE_STRING);
  $filteredPayload['articleLink']    = filter_var($payload["articleLink"],   FILTER_SANITIZE_STRING);
  $filteredPayload['userId']         = filter_var($payload['userId'],        FILTER_SANITIZE_NUMBER_INT);

  // sends error if required inputs are missing
  if(empty($filteredPayload['articleTitle']) ||
    empty($filteredPayload['articleStatus']) ||
    empty($filteredPayload['userId'])) {
    return response("failure", "One of the required items to create an article has not been provided. Please check all inputs.");
    exit;
  }

  // stores article in db
  $createNewArticle = create_new_article($filteredPayload);

  // send success or failure message to client
  if($createNewArticle == 1) {
    return response("success", $filteredPayload['articleTitle'] . " was successfully created");
  } else {
    return response("failure", $filteredPayload['articleTitle'] . " was not successfully created.");
  }
}, TRUE);

// Update Article -- passing
$article->addAction('updateArticle', function($payload) {
  $filteredPayload = array();
  $filteredPayload['articleTitle']   = filter_var($payload['articleTitle'],   FILTER_SANITIZE_STRING);
  $filteredPayload['articleSummary'] = filter_var($payload['articleSummary'], FILTER_SANITIZE_STRING);
  $filteredPayload['articleBody']    = filter_var($payload['articleBody'],    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $filteredPayload['articleStatus']  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);
  $filteredPayload['articleLink']    = filter_var($payload["articleLink"],    FILTER_SANITIZE_STRING);
  $filteredPayload['articleModified']= filter_var($payload["articleModified"],FILTER_SANITIZE_STRING);
  $filteredPayload['articleId']      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);

  // sends error if required inputs are missing
  if(empty($filteredPayload['articleTitle']) ||
    empty($filteredPayload['articleSummary']) ||
    empty($filteredPayload['articleBody']) ||
    empty($filteredPayload['articleStatus']) ||
    empty($filteredPayload['articleLink']) ||
    empty($filteredPayload['articleModified']) ||
    empty($filteredPayload['articleId'])) {
    return response("failure", "One of the required items to create an article has not been provided. Please check all inputs.");
    exit;
  }

  // updates article in db
  // Since the payload is not filtered this represents a security issue please address this
  //
  // 1. create a new named array or replace the values inside the array itself
  //
  $updateArticle = update_article($filteredPayload);

  // send success or failure message to client
  if($updateArticle) {
    return response("success", $filteredPayload['articleTitle'] . " was successfully updated");
  } else {
    return response("failure", $filteredPayload['articleTitle'] . " was not successfully updated.");
  }
}, TRUE);

// Update Article Status -- passing
$article->addAction('updateArticleStatus', function($payload) {
  $filteredPayload = array();
  $filteredPayload['articleId']      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);
  $filteredPayload['articleStatus']  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);
  $filteredPayload['articleModified'] = date('Y-m-d H:i:s');

  // sends error if required inputs are missing
  if(empty($filteredPayload['articleId'] ) || empty($filteredPayload['articleStatus'])) {
    return response("failure", "Either an article was not specified or a status was not provided. Please contact your web administrator.");
    exit;
  }

  // updates article status
  // updates article in db
  $updateArticleStatus = update_article_status($filteredPayload);

  // send success or failure message to client
  if($updateArticleStatus == 1) {
    return response("success", "Article was successfully " . $filteredPayload['articleStatus']);
  } else {
    return response("failure", "Article was not successfully " . $filteredPayload['articleStatus']);
  }
}, TRUE);

// Delete Article -- passing
$article->addAction('deleteArticle', function($payload) {
  $filteredPayload = array();
  $filteredPayload['articleId'] = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

  // sends error if required inputs are missing
  if(empty($filteredPayload['articleId'])) {
    return response("failure", "Either an article was not specified. Please contact your web administrator.");
    exit;
  }

  // deletes article
  $deleteArticle = delete_article($filteredPayload['articleId']);

  if($deleteArticle == 1) {
    return response("success", "Article deleted successfully.");
  } else {
    return response("failure", "Article was not deleted successfully.");
  }
}, TRUE);

// Get Article By ID -- passing
$article->addAction('getArticleById', function($payload) {
  $filteredPayload = array();
  $filteredPayload['articleId'] = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

  if (empty($filteredPayload['articleId'])) {
    return response("failure", "No articleId was specified.");
    exit;
  }

  $articleData = get_article_by_id($filteredPayload['articleId']);
  return dataResp("success", $articleData, "Article was retrieved successfully.");
});

// untested
$article->addAction('getPublishedArticleById', function($payload){
  $filteredPayload = array();
  $filteredPayload['articleId'] = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

  if (empty($filteredPayload['articleId'])) {
    return response("failure", "No articleId was specified.");
    exit;
  }

  $articleData = get_article_by_id($filteredPayload['articleId']);

  if($articleData['articleStatus'] === 'saved') {
    return response("failuare", "Protected resource request denied.");
    exit;
  }

  return dataResp("success", $articleData, "Article was retrieved successfully.");
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
  return dataResp("success", $articles, "All articles we retrieved.");
});

// Get Specified Number of Articles -- passing
$article->addAction('getNumberOfArticles', function($payload) {
  $numArticles = filter_var($payload['articleNumber'], FILTER_SANITIZE_NUMBER_INT);
  $articles = get_number_of_articles($numArticles);
  return dataResp("success", $articles, "Articles were retrieved successfully");
});

// untested
$article->addAction('getNumberOfPublishedArticles', function($payload){
  $numArticles = filter_var($payload['articleNumber'], FILTER_SANITIZE_NUMBER_INT);
  $articles = get_number_published_of_articles($numArticles);
  return dataResp("success", $articles, "Published articles were retrieved successfully");
});