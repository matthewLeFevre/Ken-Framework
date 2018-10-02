<?php
function create_colorPallet($colorPalletData) {
    $db = dbConnect();
    $spl= "INSERT";
    $stmt = $db->prepare($sql);
    return $rowsChaned;
}
function update_colorPallet($colorPalletData) {
    $db = dbConnect();
    $spl= "UPDATE";
    $stmt = $db->prepare($sql);
    return $rowsChaned;
}
function delete_colorPallet($colorPalletData) {
    $db = dbConnect();
    $spl= "DELETE";
    $stmt = $db->prepare($sql);
    return $rowsChaned;
}
function get_colorPallet_by_id($colorPalletData) {
    $db = dbConnect();
    $spl= "SELECT";
    $stmt = $db->prepare($sql);
    return $rowsChaned;
}

function get_colorPallet_by_sectionId($sectionId) {
    $db = dbConnect();
    $spl= "SELECT";
    $stmt = $db->prepare($sql);
    return $rowsChaned;
}

function create_font ($data) {
    $db = dbConnect();
    $sql = 'INSERT INTO';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function create_heading ($data) {
    $db = dbConnect();
    $sql = 'INSERT INTO';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function create_image ($data) {
    $db = dbConnect();
    $sql = 'INSERT INTO';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function create_textBox ($data) {
    $db = dbConnect();
    $sql = 'INSERT INTO';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


function update_font(){
    $db = dbConnect();
    $sql = 'UPDATE';
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function update_heading(){
    $db = dbConnect();
    $sql = 'UPDATE';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function update_image(){
    $db = dbConnect();
    $sql = 'UPDATE';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function update_textBox(){
    $db = dbConnect();
    $sql = 'UPDATE';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function delete_font ($data) {
    $db = dbConnect();
    $sql = "DELETE";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChaned = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function delete_heading ($data) {
    $db = dbConnect();
    $sql = "DELETE";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChaned = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function delete_image ($data) {
    $db = dbConnect();
    $sql = "DELETE";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChaned = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function delete_textBox ($data) {
    $db = dbConnect();
    $sql = "DELETE";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsChaned = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


function get_fonts_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql = "SELECT * FROM font WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NAMED);
    $stmt->closeCursor();
    return $data;
}
function get_headings_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql = "SELECT * FROM heading WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NAMED);
    $stmt->closeCursor();
    return $data;
}
function get_images_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql = "SELECT * FROM image WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NAMED);
    $stmt->closeCursor();
    return $data;
}
function get_textBoxes_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql = "SELECT * FROM textBox WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NAMED);
    $stmt->closeCursor();
    return $data;
}
function get_colorPallets_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql = "SELECT * FROM colorPallet WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NAMED);
    $stmt->closeCursor();
    return $data;
}