# Команды Artisan

## Содержание

- [Конфигурирование приложения](#application-configuration)
- [Сессии](#sessions)
- [Миграции](#migrations)
- [Бандлы](#bundles)
- [Задачи](#tasks)
- [Юнит-тесты](#unit-tests)
- [Маршруты](#routing)
- [Ключи  приложения](#keys)
- [CLI опции](#cli-options)

<a name="application-configuration"></a>
## Конфигурирование приложения <small>[(Подробнее)](/docs/install#basic-configuration)</small>

Описание  | Команда
------------- | -------------
Генерация секретного ключа приложения. Ключ приложения не будет сгенерирован, пока соответствующее поле в **config/application.php** не будет заполнено. | `php artisan key:generate`

<a name="sessions"></a>
## Таблица базы данных для сессии  <small>[(Подробнее)](/docs/session/config#database)</small>

Описание  | Команда
------------- | -------------
Создание таблицы сессии  | `php artisan session:table`

<a name="migrations"></a>
## Миграции <small>[(Подробнее)](/docs/database/migrations)</small>

Описание  | Команда
------------- | -------------
Создание таблицы миграции Laravel  | `php artisan migrate:install`
Создание миграции  | `php artisan migrate:make create_users_table`
Создание миграции для бандла  |  `php artisan migrate:make bundle::tablename`
Запуск имеющихся миграций  |  `php artisan migrate`
Запуск имеющихся миграций в приложении |  `php artisan migrate application`
Запуск всех имеющихся миграций в бандле  |  `php artisan migrate bundle`
Откат последней операции миграции  | `php artisan migrate:rollback`
Откат всех ранее запущенных миграций  |  `php artisan migrate:reset`

<a name="bundles"></a>
## Бандлы <small>[(Подробнее)](/docs/bundles)</small>

Описание  | Команда
------------- | -------------
Установка бандла  |  `php artisan bundle:install eloquent`
Обновление бандла  |  `php artisan bundle:upgrade eloquent`
Обновление всех бандлов | `php artisan bundle:upgrade`
Публикация ресурсов бандла | `php artisan bundle:publish bundle_name`
Публикация ресурсов всех бандлов | `php artisan bundle:publish`

<br>
> **Примечание:** После установки необходима [регистрация бандла](../bundles/#registering-bundles)

<a name="tasks"></a>
## Задачи <small>[(Подробнее)](/docs/artisan/tasks)</small>

Описание  | Команда
------------- | -------------
Запуск задачи  |  `php artisan notify`
Запуск задачи и передача параметров  |  `php artisan notify taylor`
Вызов определенного метода задачи  |  `php artisan notify:urgent`
Запуск задачи бандла | `php artisan admin::generate`
Вызов определенного метода задачи для бандла  |  `php artisan admin::generate:list`

<a name="unit-tests"></a>
## Юнит-тесты <small>[(Подробнее)](/docs/testing)</small>

Описание  | Команда
------------- | -------------
Запуск теста приложения  |  `php artisan test`
Запуск теста бандла  |  `php artisan test bundle-name`

<a name="routing"></a>
## Маршруты <small>[(Подробнее)](/docs/routing)</small>

Описание  | Команда
------------- | -------------
Вызов маршрута  |  `php artisan route:call get api/user/1`

<br>
> **Примечание:** Вы можете заменить get на post, put, delete, и др.

<a name="keys"></a>
## Ключи  приложения

Описание  | Команда
------------- | -------------
Генерация ключа приложения  |  `php artisan key:generate`

<br>
> **Примечание:** Вы можете назначить другую длину ключа, передав дополнительный аргумент команде.

<a name="cli-options"></a>
## CLI опции

Описание  | Команда
------------- | -------------
Установка окружения Laravel  |  `php artisan foo --env=local`
Установка соединения по умолчанию с базой данных  |  `php artisan foo --database=sqlitename`
