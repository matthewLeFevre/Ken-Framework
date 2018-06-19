<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function articleRequest($action, $payload){

  switch ($action) {
    case 'createArticle':
      $articleTitle   = filter_var($payload['articleTitle'],  FILTER_SANITIZE_STRING);
      $articleSummary = filter_var($payload['articleSummary'],FILTER_SANITIZE_STRING);
      $articleBody    = filter_var($payload['articleBody'],   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $articleStatus  = filter_var($payload['articleStatus'], FILTER_SANITIZE_STRING);
      $articleLink    = filter_var($payload["articleLink"],   FILTER_SANITIZE_STRING);
      $userId         = filter_var($payload['userId'],        FILTER_SANITIZE_NUMBER_INT);
    
      // sends error if required inputs are missing
      if(empty($articleTitle) ||
        empty($articleSummary) ||
        empty($articleBody) ||
        empty($articleStatus) ||
        empty($articleLink) ||
        empty($userId)) {
        return postResp("failure", "One of the required items to create an article has not been provided. Please check all inputs.");
        exit;
      }

      // stores article in db
      $createNewArticle = create_new_article($payload);

      // send success or failure message to client
      if($createNewArticle == 1) {
        return postResp("success", $articleTitle . " was successfully created");
      } else {
        return postResp("failure", $articleTitle . " was not successfully created.");
      }
    break;

    case 'updateArticle':
      $articleTitle   = filter_var($payload['articleTitle'],   FILTER_SANITIZE_STRING);
      $articleSummary = filter_var($payload['articleSummary'], FILTER_SANITIZE_STRING);
      $articleBody    = filter_var($payload['articleBody'],    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $articleStatus  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);
      $articleLink    = filter_var($payload["articleLink"],    FILTER_SANITIZE_STRING);
      $articleModified= filter_var($payload["articleModified"],FILTER_SANITIZE_STRING);
      $articleId      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);

      // sends error if required inputs are missing
      if(empty($articleTitle) ||
        empty($articleSummary) ||
        empty($articleBody) ||
        empty($articleStatus) ||
        empty($articleLink) ||
        empty($articleModified) ||
        empty($articleId)) {
        return postResp("failure", "One of the required items to create an article has not been provided. Please check all inputs.");
        exit;
      }

      // updates article in db
      $updateArticle = update_article($payload);

      // send success or failure message to client
      if($updateArticle == 1) {
        return postResp("success", $articleTitle . " was successfully updated");
      } else {
        return postResp("failure", $articleTitle . " was not successfully updated.");
      }
    break;

    case 'updateArticleStatus':
      $articleId      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);
      $articleStatus  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);

      // sends error if required inputs are missing
      if(empty($articleId) || empty($articleStatus)) {
        return postResp("failure", "Either an article was not specified or a status was not provided. Please contact your web administrator.");
        exit;
      }

      // updates article status
      $updateArticleStatus = update_article_status($payload);

      // send success or failure message to client
      if($updateArticleStatus == 1) {
        return postResp("success", "Article was successfully " . $articleStatus);
      } else {
        return postResp("failure", "Article was not successfully " . $articleStatus);
      }
    break;

    case 'deleteArticle':
      $articleId = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

      // sends error if required inputs are missing
      if(empty($articleId)) {
        return postResp("failure", "Either an article was not specified. Please contact your web administrator.");
        exit;
      }

      // deletes article
      $deleteArticle = delete_article($articleId);

      if($deleteArticle == 1) {
        return postResp("success", "Article deleted successfully.");
      } else {
        return postResp("failure", "Article was not deleted successfully.");
      }
    break;
    
    case 'getArticleById':
      $articleId = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

      if (empty($articleId)) {
        // empty input error
        return $error;
        exit;
      }

      $articleData = get_article_by_id($articleId);
      return $success = ["status" => "success", "data" => $articleData];
    break;

    case 'get_article_by_title':
      $articleTitle = filter_var($payload['articleTitle'], FILTER_SANITIZE_STRING);

      if (empty($articleTitle)) {
        // empty input error
        return $error;
        exit;
      }

      $articleData = get_article_by_title($articleTitle);
      return $success = ["status"=> "success", "Data" => $articleData];
    break;

    case 'getArticles':
      $articles = get_articles();
      return $success = ["status"=>"success", "articles" => $articles];
    break;
    
    case 'getNumberOfArticles':
      $articleNumber = $payload["articleNumber"];
      $articles = get_number_of_articles($articleNumber);
      return $success = ["status"=>"success", "articles" => $articles];
    break;

    default:
      return $error = ["status" => "failure", "message" => "the specified action has not been defined."];
    break;
  }
}