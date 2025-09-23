<?php
// includes/functions.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

// Redirect helper
function redirect(string $url): void {
    header("Location: " . $url);
    exit();
}

// Sanitize input
function sanitize(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Handle image upload
function uploadImage(array $file, string $targetDir) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }

    if ($file['size'] > $maxSize) {
        return false;
    }

    // Ensure target directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid('img_', true) . '.' . strtolower($extension);
    $targetPath = rtrim($targetDir, '/') . '/' . $newName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $newName; // Return filename only (store in DB)
    }

    return false;
}
