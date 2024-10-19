<?php
require 'config.php';

function getUserByPhone($phone) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->execute([$phone]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createUser($phone, $address, $email, $pin) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (phone, address, email, pin) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$phone, $address, $email, password_hash($pin, PASSWORD_DEFAULT)]);
}

function updateUserBalance($userId, $amount) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    return $stmt->execute([$amount, $userId]);
}

function getUserBalance($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
}

function addTransaction($userId, $type, $amount) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, type, amount) VALUES (?, ?, ?)");
    return $stmt->execute([$userId, $type, $amount]);
}

function transferMoney($userId, $recipientPhone, $amount) {
    global $pdo;
    // Find recipient
    $recipient = getUserByPhone($recipientPhone);
    if ($recipient) {
        // Update balances
        $updateSender = $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $updateRecipient = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $updateSender->execute([$amount, $userId]);
        $updateRecipient->execute([$amount, $recipient['id']]);
        
        // Add transactions
        addTransaction($userId, 'transfer', $amount);
        addTransaction($recipient['id'], 'transfer', $amount);
        
        return true;
    }
    return false;
}
?>
