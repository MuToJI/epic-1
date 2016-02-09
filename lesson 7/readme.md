# Безопасность ввода/вывода, куки и сессии, авторизация

## Задачи

* Проблемы безопасности
* Cookies/sessions
* Авторизация пользователя

# Ход занятия

## Вспоминаем прошлое занятие

* Виды запросов (GET, POST, PUT, DELETE)
* HTML Формы (что такое, для чего нужны, как определяются)
* Безопасность (проверка ввода, проверка вывода, sql-injection, xss)

## Теория

* Виды атак на сайт (xss, csrf, DoS, sql-injection)
* Что такое cookies, где хранятся и для чего используются
* Ограничения cookies
* Сессии, что такое и для чего нужны
* Настройки сессий
* Как хранить информацию о пароле пользователя

## Практическая реализация

* Защита csrf токеном
* Защита вывода от xss
* Выбор стилей для блога
* Хранение настроек стилей в куках
* Добавление страницы авторизации
* Авторизация пользователя и хранение токена авторизации в сессии

## Самостоятельно

* Оптимизировать код (убрать повторяющиеся куски кода, вынести в функции и константы)
* Исключить атаки csrf (добавить в формы токен)