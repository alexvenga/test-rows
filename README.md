
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

## Установка

1. Клонировать проект
2. Выполните установку зависимостей ```docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install --ignore-platform-reqs```
3. Скопировать .env.example в .env, при необходиемости внести изменения (все настройки для текущего контейнера для запуска на MacOS уже внесены)
4. Подключить алиас для ```sail``` [Документация](https://laravel.com/docs/10.x/sail#configuring-a-shell-alias)
5. Запустить docker-compose командой ```sail up -d```
6. Установить frontend-зависимости ```sail npm i --save-dev```
7. Собрать frontend ```sail npm run build```
8. Сгенерировать ключь продукта ```sail artisan key:generate```
9. Запустить миграции ```sail artisan migrate```
10. Запустить выполнение заданий в очереди ```sail artisan queue:work``` усли запустить ```queue:listen``` будет работать медленнее и нагляднее
11. Открыть адрес [localhost](http://localhost)

---

## Тестирование

1. Выполнить миграции ```sail artisan migrate --env=testing```

---

## Мысли по улучшению

Рефракторинг _RowsExcelImport_
