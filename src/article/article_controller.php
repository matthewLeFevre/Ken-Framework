<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function articleRequest($action, $payload){

  $emptyCheck = chkEmpty($payload);

  if()
  $payload = sanitizePayload($payload);
  
  switch ($action) {
    case 'createArticle':
      $payload['articleTitle']   = filter_var($payload['articleTitle'],  FILTER_SANITIZE_STRING);
      $payload['articleSummary'] = filter_var($payload['articleSummary'],FILTER_SANITIZE_STRING);
      $payload['articleBody']    = filter_var($payload['articleBody'],   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $payload['articleStatus']  = filter_var($payload['articleStatus'], FILTER_SANITIZE_STRING);
      $payload['articleLink']    = filter_var($payload["articleLink"],   FILTER_SANITIZE_STRING);
      $payload['userId']         = filter_var($payload['userId'],        FILTER_SANITIZE_NUMBER_INT);
    
      // sends error if required inputs are missing
      if(empty($payload['articleTitle']) ||
        empty($payload['articleSummary']) ||
        empty($payload['articleBody']) ||
        empty($payload['articleStatus']) ||
        empty($payload['articleLink']) ||
        empty($payload['userId'])) {
        return response("failure", "One of the required items to create an article has not been provided. Please check all inputs.");
        exit;
      }

      // stores article in db
      $createNewArticle = create_new_article($payload);

      // send success or failure message to client
      if($createNewArticle == 1) {
        return response("success", $payload['articleTitle'] . " was successfully created");
      } else {
        return response("failure", $payload['articleTitle'] . " was not successfully created.");
      }
    break;

    case 'updateArticle':
      $payload['articleTitle']   = filter_var($payload['articleTitle'],   FILTER_SANITIZE_STRING);
      $payload['articleSummary'] = filter_var($payload['articleSummary'], FILTER_SANITIZE_STRING);
      $payload['articleBody']    = filter_var($payload['articleBody'],    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $payload['articleStatus']  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);
      $payload['articleLink']    = filter_var($payload["articleLink"],    FILTER_SANITIZE_STRING);
      $payload['articleModified']= filter_var($payload["articleModified"],FILTER_SANITIZE_STRING);
      $payload['articleId']      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);

      // sends error if required inputs are missing
      if(empty($payload['articleTitle']) ||
        empty($payload['articleSummary']) ||
        empty($payload['articleBody']) ||
        empty($payload['articleStatus']) ||
        empty($payload['articleLink']) ||
        empty($payload['articleModified']) ||
        empty($payload['articleId'])) {
        return response("failure", "One of the required items to create an article has not been provided. Please check all inputs.");
        exit;
      }

      // updates article in db
      // Since the payload is not filtered this represents a security issue please address this
      //
      // 1. create a new named array or replace the values inside the array itself
      //
      $updateArticle = update_article($payload);

      // send success or failure message to client
      if($updateArticle == 1) {
        return response("success", $payload['articleTitle'] . " was successfully updated");
      } else {
        return response("failure", $payload['articleTitle'] . " was not successfully updated.");
      }
    break;

    case 'updateArticleStatus':
      $payload['articleId']      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);
      $payload['articleStatus']  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);

      // sends error if required inputs are missing
      if(empty($payload['articleId'] ) || empty($payload['articleStatus'])) {
        return response("failure", "Either an article was not specified or a status was not provided. Please contact your web administrator.");
        exit;
      }

      // updates article status
      // updates article in db
      $updateArticleStatus = update_article_status($payload);

      // send success or failure message to client
      if($updateArticleStatus == 1) {
        return response("success", "Article was successfully " . $payload['articleStatus']);
      } else {
        return response("failure", "Article was not successfully " . $payload['articleStatus']);
      }
    break;

    case 'deleteArticle':
      $payload['articleId'] = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

      // sends error if required inputs are missing
      if(empty($payload['articleId'])) {
        return response("failure", "Either an article was not specified. Please contact your web administrator.");
        exit;
      }

      // deletes article
      $deleteArticle = delete_article($payload['articleId']);

      if($deleteArticle == 1) {
        return response("success", "Article deleted successfully.");
      } else {
        return response("failure", "Article was not deleted successfully.");
      }
    break;
    
    case 'getArticleById':
      $payload['articleId'] = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

      // empty input error
      if (empty($payload['articleId'])) {
        return response("failure", "No articleId was specified.");
        exit;
      }

      $articleData = get_article_by_id($payload['articleId']);
      return dataResp("success", $payload['articleData'], "Article was retrieved successfully.");
    break;

    case 'get_article_by_title':
      $payload['articleTitle'] = filter_var($payload['articleTitle'], FILTER_SANITIZE_STRING);

      if (empty($payload['articleTitle'])) {
        // empty input error
        return response("failure", "No articleTitle was specified.");
        exit;
      }

      $articleData = get_article_by_title($payload['articleTitle']);
      return dataResp("success", $articleData, "article was retrieved successfully.");
    break;

    case 'getArticles':
      $articles = get_articles();
      return dataResp("success", $articles, "All articles we retrieved.");
    break;
    
    case 'getNumberOfArticles':
      $payload['articleNumber'] = $payload["articleNumber"];
      $articles = get_number_of_articles($payload['articleNumber']);
      return response("success", $articles, "Articles were retrieved successfully");
    break;

    default:
      return response("failure", "The specified action has not been defined.");
    break;
  }
}