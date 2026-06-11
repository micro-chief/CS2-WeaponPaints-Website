<?php
session_start();

// 1. Проверяем авторизацию пользователя
if (!isset($_SESSION['steamid'])) {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    $steamid = $_SESSION['steamid'];
    
    // 2. Базовая проверка на ошибки загрузки PHP
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Ошибка при загрузке файла. Код: " . $file['error']);
    }

    // 3. ОГРАНИЧЕНИЕ РАЗМЕРА: Максимум 20 МБ (20 * 1024 * 1024 байт)
    $max_size = 20 * 1024 * 1024; 
    if ($file['size'] > $max_size) {
        die("Ошибка: Файл слишком большой! Максимальный размер аватарки — 20 МБ.");
    }

    // 4. ПРОВЕРКА СОДЕРЖИМОГО: Читаем реальный MIME-тип файла
    $file_info = getimagesize($file['tmp_name']);
    if ($file_info === false) {
        die("Ошибка: Выбранный файл не является валидным изображением.");
    }

    $mime_type = $file_info['mime'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];

    if (!in_array($mime_type, $allowed_types)) {
        die("Ошибка: Разрешены только форматы изображений JPG, PNG и WEBP.");
    }

    // 5. ОПРЕДЕЛЕНИЕ ПУТИ СОХРАНЕНИЯ
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/src/avatars/';
    $targetFile = $targetDir . $steamid . '.png';

    // Убедимся, что папка существует, если нет — создаем с правами на запись
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // 6. ОПТИМИЗАЦИЯ И СЖАТИЕ НА ЛЕТУ (Ресайз до 150x150 пикселей)
    $width = $file_info[0];
    $height = $file_info[1];
    $new_width = 150;
    $new_height = 150;

    // Создаем холст для новой уменьшенной аватарки
    $thumb = imagecreatetripartite = imagecreatetruecolor($new_width, $new_height);

    // Подгружаем исходную картинку в зависимости от её реального формата
    if ($mime_type === 'image/jpeg') {
        $source = imagecreatefromjpeg($file['tmp_name']);
    } elseif ($mime_type === 'image/png') {
        $source = imagecreatefrompng($file['tmp_name']);
        // Сохраняем прозрачность для PNG
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    } elseif ($mime_type === 'image/webp') {
        $source = imagecreatefromwebp($file['tmp_name']);
    }

    // Переносим исходную картинку на новый холст с изменением размера (сжатием)
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Сохраняем готовую оптимизированную аватарку на диск строго как PNG
    // 6 — это средний уровень сжатия PNG (от 0 до 9) для баланса качества и веса
    if (imagepng($thumb, $targetFile, 6)) {
        // Очищаем оперативную память от остатков обработки графики
        imagedestroy($thumb);
        imagedestroy($source);

        // Возвращаем игрока назад на страницу
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        imagedestroy($thumb);
        imagedestroy($source);
        echo "Произошла ошибка при оптимизации и сохранении файла.";
    }
} else {
    header('Location: /');
    exit;
}
