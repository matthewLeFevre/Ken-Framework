<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function articleRequest($action, $payload){

  // $emptyCheck = chkEmpty($payload);

  // if()
  // $payload = sanitizePayload($payload);
  
  switch ($action) {
    case 'createArticle':
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
        empty($filteredPayload['articleSummary']) ||
        empty($filteredPayload['articleBody']) ||
        empty($filteredPayload['articleStatus']) ||
        empty($filteredPayload['articleLink']) ||
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
    break;

    case 'updateArticle':
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
      if($updateArticle == 1) {
        return response("success", $filteredPayload['articleTitle'] . " was successfully updated");
      } else {
        return response("failure", $filteredPayload['articleTitle'] . " was not successfully updated.");
      }
    break;

    case 'updateArticleStatus':
      $filteredPayload = array();
      $filteredPayload['articleId']      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);
      $filteredPayload['articleStatus']  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);

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
    break;

    case 'deleteArticle':
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
    break;
    
    case 'getArticleById':
      $filteredPayload = array();
      $filteredPayload['articleId'] = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

      // empty input error
      if (empty($filteredPayload['articleId'])) {
        return response("failure", "No articleId was specified.");
        exit;
      }

      $articleData = get_article_by_id($filteredPayload['articleId']);
      return dataResp("success", $filteredPayload['articleData'], "Article was retrieved successfully.");
    break;

    case 'get_article_by_title':
      $filteredPayload = array();
      $filteredPayload['articleTitle'] = filter_var($payload['articleTitle'], FILTER_SANITIZE_STRING);

      if (empty($filteredPayload['articleTitle'])) {
        // empty input error
        return response("failure", "No articleTitle was specified.");
        exit;
      }

      $articleData = get_article_by_title($filteredPayload['articleTitle']);
      return dataResp("success", $articleData, "article was retrieved successfully.");
    break;

    case 'getArticles':
      $articles = get_articles();
      return dataResp("success", $articles, "All articles we retrieved.");
    break;
    
    case 'getNumberOfArticles':
      $numArticles = filter_var($payload['articleNumber'], FILTER_SANITIZE_NUMBER_INT);
      $articles = get_number_of_articles($numArticles);
      return dataResp("success", $articles, "Articles were retrieved successfully");
    break;

    default:
      return response("failure", "The specified action has not been defined.");
    break;
  }
}