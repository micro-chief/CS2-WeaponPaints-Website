# CS2 WeaponPaints Website — LAN & No-Internet Edition 🚀

[Русское описание находится ниже](#russian-description)

This is a modified, fully autonomous version of the web panel for the `CS2-WeaponPaints` plugin (based on the original repository by LielXD). 

The main feature of this build is **100% autonomy**. The website is perfectly optimized for closed local networks (LAN), cyber cafes, or servers without any internet connection.

## ✨ Features & Changes:
* 🔑 **Steamless Authentication**: Removed the requirement to log in via official Steam OpenID. Users now simply enter their text field on the website.
* 📋 **In-game Guide for Players**: Integrated a clear text and visual guide directly into the login page showing players how to get their SteamID64 via the game console (`status`).
* 🔌 **Completely Disabled Steam API**: Removed all Valve server requests that cause infinite loading times without internet. Player profiles no longer freeze due to network timeouts.
* 🖼️ **Local Custom Avatars**: Implemented a local file upload system for custom profile pictures! Avatars are saved on your server and tied to the user's SteamID. If no avatar is uploaded, a default knife image is shown.
* 🔤 **Autonomous Fonts & Assets**: The *Fredoka* font and all weapon/glove/sticker/music kit images are fully hosted locally.
* 📂 **Absolute Paths (Fix 302/404)**: Fixed routing bugs in deep category submenus that used to cause item images to disappear.

## 🚀 Installation & Setup (XAMPP / Linux Nginx)

1. Rename the `remove-before-dot.htaccess` file to `.htaccess`.
2. Clone the repository into your web server's root folder (`htdocs` or `/var/www/html/`).
3. ⚠️ **Important asset note:** To display images on the site, download the folder from the repository — [website/img/skins](https://github.com/Nereziel/cs2-WeaponPaints/tree/main/website/img/skins). Unfortunately, not all the pictures are available. For example, some gloves are missing.

## 📋 Requirements

* **Plugin:**<br>
 [WeaponPaints](https://github.com/Nereziel/cs2-WeaponPaints) installed

* **Webserver:**
  * **Apache:** Use the included `.htaccess` file (make sure `mod_rewrite` is enabled in XAMPP/Apache config).
  * **Nginx:** Add this location block inside your `server { ... }` configuration file:
    ```nginx
    location / {
        try_files \$uri \(uri/ /index.php?path=\)query_string;
    }
    ```
* **PHP:** Ensure the following extensions are enabled in your `php.ini` file:
  * `extension=curl`
  * `extension=pdo_mysql`
 
---

<a name="russian-description"></a>
# CS2 WeaponPaints Website — LAN & No-Internet Edition (На русском) 🇷🇺

Это модифицированная, полностью автономная версия веб-панели для плагина `CS2-WeaponPaints` (основано на оригинальном репозитории LielXD). 

Главная фишка этой сборки — **100% автономность**. Сайт идеально подходит для работы в закрытых локальных сетях (LAN), компьютерных клубах или на серверах без выхода в интернет.

## ✨ Что было изменено и добавлено:
* 🔑 **Авторизация без Steam OpenID**: Убрана необходимость входить через официальный сайт Steam. Теперь пользователи просто вводят свой SteamID64 прямо на сайте.
* 📋 **Инструкция для игроков**: В окно входа встроена наглядная текстовая и графическая подсказка, как узнать свой SteamID64 через консоль игры (`status`).
* 🔌 **Полное отключение Steam API**: Вырезаны все зависающие без интернета запросы к серверам Valve. Профиль игрока больше не зависает по таймауту.
* 🖼️ **Локальные аватарки**: Реализована система загрузки собственных аватарок! Картинки сохраняются на сервере и привязываются к SteamID. Если аватарка не загружена, отображается дефолтный нож.
* 🔤 **Автономные шрифты и ресурсы**: Шрифт *Fredoka* и все иконки (скины, перчатки, наклейки, музыкальные наборы) переведены в локальный режим работы.
* 📂 **Абсолютные пути (Fix 302/404)**: Исправлены баги маршрутизации в глубоких категориях меню, из-за которых пропадали картинки предметов.

## 🚀 Установка и запуск (XAMPP / Linux Nginx)

1. Переименуйте файл `remove-before-dot.htaccess` в `.htaccess`.
2. Склонируйте репозиторий в корневую папку вашего веб-сервера (`htdocs` или `/var/www/html/`).
3. ⚠️ **Важное примечание по графике:** Чтобы на сайте отображались картинки предметов, скачайте папку из оригинального репозитория — [website/img/skins](https://github.com/Nereziel/cs2-WeaponPaints/tree/main/website/img/skins). К сожалению, доступны не все изображения (например, отсутствуют некоторые перчатки).

##  Требования

*  **Плагин**<br>
  [WeaponPaints](https://github.com/Nereziel/cs2-WeaponPaints) Установлен

* **Веб-сервер:**
  * **Apache:** Используйте встроенный файл `.htaccess` (убедитесь, что модуль `mod_rewrite` включен в настройках XAMPP/Apache).
  * **Nginx:** Добавьте этот блок конфигурации внутрь секции `server { ... }` вашего `.conf` файла:
    ```nginx
    location / {
        try_files \$uri \(uri/ /index.php?path=\)query_string;
    }
    ```
* **PHP:** Убедитесь, что в файле `php.ini` раскомментированы и включены следующие расширения:
  * `extension=curl`
  * `extension=pdo_mysql`
