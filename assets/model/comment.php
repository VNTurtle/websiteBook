<?php

function connect() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=db_book", "root", "");
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function thembl($iduser, $idsp, $noidung) {
    $sql = "INSERT INTO comment (UserId, BookId, Content) VALUES (:iduser, :idsp, :noidung)";
    $conn = connect();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':iduser', $iduser);
    $stmt->bindParam(':idsp', $idsp);
    $stmt->bindParam(':noidung', $noidung);
    $stmt->execute();
}

function showbl($productId) {
    $sql = "SELECT c.*, a.FullName 
            FROM comment c 
            JOIN account a ON c.UserId = a.Id 
            WHERE c.BookId = :idsp 
            ORDER BY c.id DESC";
    $conn = connect();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idsp', $productId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
}

