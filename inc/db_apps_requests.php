<?php
require_once(__DIR__ . '/db_connect.php');

function getAllApps(PDO $pdo): array
{
    $stmt = $pdo->prepare('
        SELECT * FROM apps
        WHERE is_enabled IS TRUE
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}

// inc/db_apps_requests.php

function createApp(PDO $pdo, string $name, string $description, string $creator, string $file, bool $isEnabled = true): string|false
{
    $stmt = $pdo->prepare('
        INSERT INTO apps(name, description, creator, file, is_enabled)
        VALUES (:name, :description, :creator, :file, :is_enabled)
    ');

    $stmt->execute([
        'name' => $name,
        'description' => $description,
        'creator' => $creator,
        'file' => $file,
        'is_enabled' => $isEnabled ? 1 : 0,
    ]);

    return $pdo->lastInsertId();
}

function retrieveApp(PDO $pdo, int $id): array|false
{
    $stmt = $pdo->prepare('
        SELECT * FROM apps
        WHERE app_id = :id
    ');
    $stmt->execute(['id' => $id,]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateApp(PDO $pdo, int $id, string $name, string $description, string $creator, string $file, bool $isEnabled = true): bool
{
    $stmt = $pdo->prepare('
        UPDATE apps 
        SET name = :name, description = :description, creator = :creator, file = :file, is_enabled = :is_enabled 
        WHERE app_id = :id
    ');

    return $stmt->execute([
        'id' => $id,
        'name' => $name,
        'description' => $description,
        'creator' => $creator,
        'file' => $file,
        'is_enabled' => $isEnabled,
    ]);
}

function readApp(PDO $pdo, int $id): array|false
{
    $stmt = $pdo->prepare('
        SELECT a.*, c.comment_id, c.comment AS details, c.user_id,  DATE_FORMAT(c.created_at, "%d/%m/%Y") AS comment_date, u.full_name 
        FROM apps a 
        LEFT JOIN comments c ON c.app_id = a.app_id
        LEFT JOIN users u ON u.user_id = c.user_id
        WHERE a.app_id = :id 
        ORDER BY c.created_at DESC
    ');
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteApp(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare('DELETE FROM apps WHERE app_id = :id');
    return $stmt->execute(['id' => $id]);
}
