
## Задание

Laravel (Docker, Laravel echo, redis, mariadb)

Развернуть laravel в docker с установкой laravel cron и сервером очередей rabbitmq

1. Реализовать контроллер с валидацией и загрузкой excel файла
2. Загруженный файл через jobs поэтапно (по 1000 строк) парсить в бд (таблица rows)
3. Прогресс парсинга файла хранить в redis (уникальный ключ + количество обработанных строк)
4. Поля excel:
   1. id
   2. name
   3. date (d.m.Y)
5. Для парсинга excel можете использовать maatwebsite/excel
6. Реализовать контроллер для вывода данных (rows) с группировкой по date - двумерный массив
7. Будет плюсом если вы реализуете через laravel echo передачу event-а на создание записи в rows
8. Написать тесты

---

## Информация

---

## Мысли по улучшению
