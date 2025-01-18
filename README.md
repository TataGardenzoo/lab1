# Подсистема авторизации

## Требования
- PHP 7.0 или выше
- MySQL 5.6 или выше
- Веб-сервер Apache или Nginx

## Установка
1. Скопируйте все файлы в корневую директорию вашего веб-сервера
2. Импортируйте файл `database.sql` в вашу MySQL базу данных
3. Настройте параметры подключения к базе данных в файле `lib/connect.php`

## Данные для входа администратора
- Логин: admin
- Пароль: admin123

## Структура проекта
- `index.php` - главная страница
- `lib/` - библиотеки
  - `connect.php` - подключение к базе данных
  - `function_global.php` - глобальные функции
- `main/` - основные страницы
  - `main.php` - главная страница после авторизации
- `registration/` - система регистрации
  - `index.php` - обработчик регистрации
  - `template/` - шаблоны
    - `auth.php` - форма авторизации
    - `registration.php` - форма регистрации
- `js/` - JavaScript файлы
  - `regform.js` - валидация формы регистрации
