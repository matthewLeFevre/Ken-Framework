<?php
function create_colorPallet($data) {
    $db = dbConnect();
    $sql= "INSERT INTO colorPallet (itemOrder, sectionId) VALUES (:itemOrder, :sectionId)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $data['sectionId'], PDO::PARAM_INT);
    $stmt->bindValue(':itemOrder', $data['itemOrder'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function update_colorPallet($data) {
    $db = dbConnect();
    $sql= "UPDATE colorPallet SET itemOrder = :itemOrder WHERE colorPalletId = :colorPalletId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colorPalletId', $data['colorPalletId'], PDO::PARAM_INT);
    $stmt->bindValue(':itemOrder', $data['itemOrder'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function delete_colorPallet($data) {
    $db = dbConnect();
    $sql= "DELETE FROM colorPallet WHERE colorPalletId = :colorPalletId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colorPalletId', $data['colorPalletId'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function get_colorPallet_by_id($data) {
    $db = dbConnect();
    $sql= "SELECT * FROM font WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    return $rowsChanged;
}
function get_colorPallet_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql= "SELECT * FROM colorPallet WHERE sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    return $rowsChanged;
}

function create_colorSwatch($data) {
    $db = dbConnect();
    $sql= "INSERT INTO colorSwatch (itemOrder, colorPalletId) VALUES (:itemOrder, :colorPalletId)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $data['colorPalletId'], PDO::PARAM_INT);
    $stmt->bindValue(':itemOrder', $data['itemOrder'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
function update_colorSwatch($data) {
    $db = dbConnect();
    $sql= "UPDATE colorSwatch SET itemOrder = :itemOrder WHERE colorSwatchId = :colorSwatchId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colorPalletId', $data['colorSwatchId'], PDO::PARAM_INT);
    $stmt->bindValue(':itemOrder', $data['itemOrder'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function get_colorPallets_by_sectionId($sectionId) {
    $db = dbConnect();
    $sql = "SELECT cp.*, cs.colorSwatchHex, cs.colorSwatchTitle, cs.colorSwatchRGB, cs.colorSwatchVar
            FROM colorPallet AS cp
            LEFT JOIN colorSwatch AS cs
            ON cp.colorPalletId = cs.colorPalletId
            WHERE cp.sectionId = :sectionId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sectionId', $sectionId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NAMED);
    $stmt->closeCursor();
    // var_dump($data);
    // exit;
    return $data;
}

function delete_colorSwatch($data) {
    $db = dbConnect();
    $sql= "DELETE FROM colorSwatch WHERE colorPalletId = :colorSwatchId";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':colorPalletId', $data['colorSwatchId'], PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}