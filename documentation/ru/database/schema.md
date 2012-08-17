# Schema конструктор таблиц

## Содержание

- [Основы](#the-basics)
- [Создание и удаление таблиц](#creating-dropping-tables)
- [Добавление полей](#adding-columns)
- [Удаление полей](#dropping-columns)
- [Добавление идексов](#adding-indexes)
- [Удаление индексов](#dropping-indexes)
- [Внешние ключи](#foreign-keys)

<a name="the-basics"></a>
## Основы

Конструктор структур предоставляет методы для создания и модификации таблиц баз данных. Используя легкий синтаксис, вы можете работать с таблицами без привлечения специальных средств SQL.

*Рекомендуем прочитать:*

- [Миграции](/docs/database/migrations)

<a name="creating-dropping-tables"></a>
## Создание и удаление таблиц

Класс **Schema** используется для создания и удаления таблиц. Лучше посмотреть примеры:

#### Создание таблицы:

	Schema::create('users', function($table)
	{
		$table->increments('id');
	});

Рассмотрим этот пример. Метод **create** указывает конструктору таблиц создать новую таблицу 'users', вторым аргументом посредством анонимной (закрытой) функции, которой передается объект таблицы, определяются поля и индексы таблицы.

#### Удаление таблицы из базы данных:

	Schema::drop('users');

#### Удаление таблицы из данного соединения с базой данных:

	Schema::drop('users', 'connection_name');

Иногда вам может потребоваться указать подключение к базе данных, с которым операции конструктора должны быть выполнены.

#### Определение соединения для операций:

	Schema::create('users', function($table)
	{
		$table->on('connection');
	});

<a name="adding-columns"></a>
## Добавление полей

Методы консруктора таблиц позволяют добавить поля без использования утилит SQL. Примеры использования:

Команда  | Описание
------------- | -------------
`$table->increments('id');`  |  Инкрементируемый ID
`$table->string('email');`  |  VARCHAR поле
`$table->string('name', 100);`  |  VARCHAR поле с указанием длины
`$table->integer('votes');`  |  INTEGER поле
`$table->float('amount');`  |  FLOAT поле
`$table->boolean('confirmed');`  |  BOOLEAN поле
`$table->date('created_at');`  |  DATE поле
`$table->timestamp('added_on');`  |  TIMESTAMP поле
`$table->timestamps();`  |  Добавление **created\_at** и **updated\_at** полей
`$table->text('description');`  |  TEXT поле
`$table->blob('data');`  |  BLOB поле
`->nullable()`  |  Назначение: поле может иметь значение **NULL**

> **Примечание:** "Boolean" типы представляют собой SMALLINT поле применительно к СУБД.

#### Пример создания таблицы и добавления полей

	Schema::table('users', function($table)
	{
		$table->create();
		$table->increments('id');
		$table->string('username');
		$table->string('email');
		$table->string('phone')->nullable();
		$table->text('about');
		$table->timestamps();
	});

<a name="dropping-columns"></a>
## Удаление полей

#### Удаление поля из таблицы:

	$table->drop_column('name');

#### Удаление нескольких полей:

	$table->drop_column(array('name', 'email'));

<a name="adding-indexes"></a>
## Добавление индексов

Schema конструктор поддерживает несколько типов индексов. Есть два способа добавитьь индекс. Каждый тип индекса имеет свой метод. Т.е. вы можете назначить индекс при построении таблицы:

#### Быстрое создание поля с индексом:

	$table->string('email')->unique();

Если вам больше нравится определение индексов на отдельной строке, вот пример использования методов для каждого индекса:

Команда  | Описание
------------- | -------------
`$table->primary('id');`  |  Добавление первичного ключа
`$table->primary(array('fname', 'lname'));`  |  Добавление составного ключа
`$table->unique('email');`  |  Добавление уникального индекса
`$table->fulltext('description');`  |  Добавление полнотекстового индекса
`$table->index('state');`  |  Добавление обычного индекса

<a name="dropping-indexes"></a>
## Удаление индексов

Для удаления индекса нужно указать его имя. Laravel присваивает интуитивно понятные имена индексам.
Просто соедините имя таблицы с именем индексированного поля, затем добавьте тип индекса. Например:


Команда  | Описание
------------- | -------------
`$table->drop_primary('users_id_primary');`  |  Удаление первичного индекса из таблицы "users"
`$table->drop_unique('users_email_unique');`  |  Удаление уникального индекса из таблицы "users"
`$table->drop_fulltext('profile_description_fulltext');`  |  Удаление полнотекстового индекса из таблицы "profile"
`$table->drop_index('geo_state_index');`  |  Удаление основного индекса из таблицы "geo"

<a name="foreign-keys"></a>
## Внешние ключи

Вы можете легко добавить внешний ключ к таблице, используя легкий интерфейс Schema конструктора. Например, предположим, у вас есть **user_id** в таблице **posts**, которая ссылается на поле **id** **users** таблицы.
Следующий код показывает, как добавить внешний ключ, связанный с полем:

	$table->foreign('user_id')->references('id')->on('users');

Вы также можете определить "on delete" и "on update" действия с внешним ключом:

	$table->foreign('user_id')->references('id')->on('users')->on_delete('restrict');

	$table->foreign('user_id')->references('id')->on('users')->on_update('cascade');

Вы можете легко удалить внешние ключи. Имена внешних ключей аналогичны разделу [удаление индексов](#dropping-indexes). Например:

	$table->drop_foreign('posts_user_id_foreign');
