<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

function articleRequest($action, $payload){
  switch ($action) {
    case 'createNewArticle':
      $articleTitle   = filter_var($payload['articleTitle'],  FILTER_SANITIZE_STRING);
      $articleSummary = filter_var($payload['articleSummary'],FILTER_SANITIZE_STRING);
      $articleBody    = filter_var($payload['articleBody'],   FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $articleStatus  = filter_var($payload['articleStatus'], FILTER_SANITIZE_STRING);
      $articleLink    = filter_var($payload["articleLink"],   FILTER_SANITIZE_STRING);
      $userId         = filter_var($payload['userId'],        FILTER_SANITIZE_NUMBER_INT);

      if(empty($articleTitle) ||
        empty($articleSummary) ||
        empty($articleBody) ||
        empty($articleStatus) ||
        empty($articleLink) ||
        empty($userId)) {
        // throw an error fill in all input fields
        $error = "error";
        return $error;
        exit;
      }

      $createNewArticle = create_new_article($payload);
      if($createNewArticle == 1) {
        // create custom notification that artical creation was successful
        return $success;
        exit;
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


      if(empty($articleTitle) ||
        empty($articleSummary) ||
        empty($articleBody) ||
        empty($articleStatus) ||
        empty($articleLink) ||
        empty($articleModified) ||
        empty($articleId)) {
        // throw an error fill in all input fields
        $error = "error";
        return $error;
        exit;
      }

      $updateArticle = update_article($payload);
      if($updateArticle == 1) {
        // create custom notification that artical update was successful
        return $success;
        exit;
      }
    break;

    case ' updateArticleStatus':
      $articleId      = filter_var($payload["articleId"],      FILTER_SANITIZE_NUMBER_INT);
      $articleStatus  = filter_var($payload['articleStatus'],  FILTER_SANITIZE_STRING);

      if(empty($articleId) || empty($articleStatus)) {
        // throw an error fill in all input fields
        $error = "error";
        return $error;
        exit;
      }

      $updateArticleStatus = update_article_status($payload);
      if($updateArticleStatus == 1) {
        // create custom notification that artical update was successful
        return $success;
        exit;
      }
    break;

    case 'deleteArticle':
      $articleId = filter_var($payload['articleId'], FILTER_SANITIZE_NUMBER_INT);

      if (empty($articleId)) {
        // empty input error
        return $error;
        exit;
      }

      $deleteArticle = delete_article($articleId);
      if($deleteArticle == 1) {
        return $success;
        exit;
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
      return $success = ["status"="success", $articleData];
    break;

    case 'get_article_by_title':
      $articleTitle = filter_var($payload['articleTitle'], FILTER_SANITIZE_STRING);

      if (empty($articleTitle)) {
        // empty input error
        return $error;
        exit;
      }

      $articleData = get_article_by_title($articleTitle);
      return $success = ["status"="success", $articleData];
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
  }
}