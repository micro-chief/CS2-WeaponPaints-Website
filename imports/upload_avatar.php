<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['steamid'])) {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    $steamid = $_SESSION['steamid'];
    
    // Проверяем на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Ошибка при загрузке файла.");
    }

    // Проверяем тип файла (разрешаем только JPEG и PNG)
    $fileType = mime_content_type($file['tmp_name']);
    if ($fileType !== 'image/png' && $fileType !== 'image/jpeg') {
        die("Ошибка: Разрешены только файлы форматов PNG и JPG.");
    }

    // Путь, куда сохраняем картинку (переименовываем в SteamID64)
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/src/avatars/';
    $targetFile = $targetDir . $steamid . '.png';

    // Перемещаем файл из временной папки в нашу постоянную
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Успешно загружено! Возвращаем пользователя назад на ту страницу, откуда он пришел
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Произошла ошибка при сохранении файла на сервере.";
    }
} else {
    header('Location: /');
    exit;
}