<?php
// Включаем сессии, если они еще не запущены скриптами сайта
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['steamid'])) {
    $input_id = trim($_POST['steamid']);
    
    // Регулярное выражение для поиска 17-значного SteamID64 в тексте
    // (поможет, если пользователь скопирует ID с пробелом или лишними символами)
    if (preg_match('/7656119\d{10}/', $input_id, $matches)) {
        $steamid = $matches[0];
    } else {
        // Если регулярка не сработала, просто очищаем строку от не-цифр
        $steamid = preg_replace('/[^0-9]/', '', $input_id);
    }

    // Проверяем базовую валидность SteamID64 (ровно 17 цифр)
    if (strlen($steamid) === 17) {
        // Записываем SteamID в сессию. 
        // Большинство скриптов этого репозитория ищут именно $_SESSION['steamid']
        $_SESSION['steamid'] = $steamid;
        
        // Перенаправляем пользователя на главную страницу
        header('Location: index.php');
        exit;
    } else {
        // Перенаправляем обратно с ошибкой
        header('Location: index.php?error=invalid_steamid');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}