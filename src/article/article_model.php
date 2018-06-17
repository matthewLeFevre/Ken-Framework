<?php 


// create article
function create_new_article($articleData) {
  $db = dbConnect();
  $sql = 'INSERT INTO article (articleTitle, articleSummary, articleBody, articleStatus, articleLink, userId) VALUES (:articleTitle, :articleSummary, :articleBody, :articleStatus, :articleLink, :userId)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':articleTitle',   $articleData['articleTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':articleSummary', $articleData['articleSummary'], PDO::PARAM_STR);
  $stmt->bindValue(':articleBody',    $articleData['articleBody'],    PDO::PARAM_STR);
  $stmt->bindValue(':articleStatus',  $articleData['articleStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':articleLink',    $articleData['articleLink'],    PDO::PARAM_STR);
  $stmt->bindValue(':userId',         $articleData['userId'],         PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}
// update article
// - add like
// - add share

function update_article($articleData) {
  $db = dbConnect();
  $sql = 'UPDATE article SET articleTitle = :articleTitle, articleSummary = :articleSummary, articleBody = :articleBody, articleStatus= :articleStatus, articleLink = :articleLink, articleModified = :articleModiefied WHERE articleId = :articleId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':articleTitle',   $articleData['articleTitle'],   PDO::PARAM_STR);
  $stmt->bindValue(':articleSummary', $articleData['articleSummary'], PDO::PARAM_STR);
  $stmt->bindValue(':articleBody',    $articleData['articleBody'],    PDO::PARAM_STR);
  $stmt->bindValue(':articleStatus',  $articleData['articleStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':articleLink',    $articleData['articleLink'],    PDO::PARAM_STR);
  $stmt->bindValue(':articleModified',$articleData['articleModified'],PDO::PARAM_STR);
  $stmt->bindValue(':articleId',      $articleData['articleId'],      PDO::PARAM_INT;
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function update_article_status($articleData) {
  $db = dbConnect();
  $sql = 'UPDATE article SET articleStatus= :articleStatus, articleModified = :articleModiefied WHERE articleId = :articleId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':articleStatus',  $articleData['articleStatus'],  PDO::PARAM_STR);
  $stmt->bindValue(':articleModified',$articleData['articleModified'],PDO::PARAM_STR);
  $stmt->bindValue(':articleId',      $articleData['articleId'],      PDO::PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// delete article

function delete_article($articleId) {
  $db = dbConnect();
  $sql = 'DELETE article WHERE articleId = :articleId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':articleId', $articleId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// get article by id

function get_article_by_id($articleId) {
  $db = dbConnect();
  $sql = "SELECT * FROM article  WHERE articleId = :articleId";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':articleId', $articleId, PDO::PARAM_INT);
  $stmt->execute();
  $articleData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $articleData;
}

// get article by name

function get_article_by_title($articleTitle) {
  $db = dbConnect();
  $sql = "SELECT * FROM article  WHERE articleTitle = :articleTitle";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':articleTitle', $articleTitle, PDO::PARAM_STR);
  $stmt->execute();
  $articleData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $articleData;
}

// get all articles

function get_articles() {
  $db = dbConnect();
  $sql = "SELECT * FROM article ORDER BY articleCreated ASC";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $articleData = $stmt->fetchAll(PDO::FETCH_NAMED);
  $stmt->closeCursor();
  return $articleData;
}

// get variable articles
// Implement the number here
function get_number_of_articles($numberOfArticles) {
  $db = dbConnect();
  $sql = "SELECT * FROM article ORDER BY articleCreated ASC LIMIT " . $numberOfArticles;
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $articles = $stmt->fetchAll(PDO::FETCH_NUM);
  $stmt->closeCursor();
  return $articles;
}