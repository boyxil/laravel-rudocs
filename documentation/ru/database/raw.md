# Основные запросы

## Содержание

- [Основы](#the-basics)
- [Другие методы запросов](#other-query-methods)
- [PDO соединения](#pdo-connections)

<a name="the-bascis"></a>
## Основы

Метод **query** служит для содания основных SQL запросов. 

#### Получение записи из базы:

	$users = DB::query('select * from users');

#### Выборка записей с использованием связывания:

	$users = DB::query('select * from users where name = ?', array('test'));

#### Вставка записи

	$success = DB::query('insert into users values (?, ?)', $bindings);

#### Сохранение записи и получение количества обновленных строк:

	$affected = DB::query('update users set name = ?', $bindings);

#### Удаление записи и получение количества обновленных строк:

	$affected = DB::query('delete from users where id = ?', array(1));

<a name="other-query-methods"></a>
## Другие методы запросов

Laravel несколько других методов для создания запросов:

#### Запуск SELECT запроса и возврат первого результата:

	$user = DB::first('select * from users where id = 1');

#### Запуск SELECT запроса и получение значения столбца:

	$email = DB::only('select email from users where id = 1');

<a name="pdo-connections"></a>
## PDO соединения

#### Использование PDO:

	$pdo = DB::connection('sqlite')->pdo;

> **Примечание:** Если имя соединения не указано, возвращается **default** соединение.
