<?php
    if(!function_exists("Path")) {
        return;
    }

    if(isset($_SESSION['steamid'])) {
        header('Location: ./skins/');
        exit;
    }

    $title_num = rand(0, count($translations->login->titles)-1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/login.css">
    <title><?= $translations->website_name; ?> - login</title>
</head>
<body <?= $bodyStyle ?? "" ?>>
    
    <div id="loading">
        <span></span>
    </div>

<form action="<?= GetPrefix(); ?>local_login.php" method="POST" onsubmit="document.getElementById('loading').setAttribute('data-loading', true);">
    <h2><?= $Translations->login->header; ?></h2>
    
    <div style="margin: 20px 0; text-align: left;">
        <label for="steamid" style="color: #ccc; display: block; margin-bottom: 8px; font-size: 14px;">Введите ваш SteamID64:</label>
        <input type="text" id="steamid" name="steamid" placeholder="76561198XXXXXXXXX" required 
               style="width: 100%; padding: 12px; background: #1a1a1a; border: 1px solid #444; color: #fff; border-radius: 4px; box-sizing: border-box; font-size: 16px;">
    </div>

    <button class="main-btn" type="submit">
        <?= $Translations->login->button; ?>
    </button>
</form>

</body>
</html>