# Конфигурация баз данных

## Содержание

- [Быстрый старт с SQLite](#quick)
- [Конфигурирование других баз данных](#server)
- [Установка имени соединения по умолчанию](#default)

Laravel "из коробки" поддерживает следующие базы данных:

- MySQL
- PostgreSQL
- SQLite
- SQL Server

Все конфигурирование производится в файле **application/config/database.php**.

<a name="quick"></a>
## Быстрый старт с SQLite

По умолчанию, Laravel сконфигурирован для использования SQLite. Если вы намерены использовать SQLite, вам не нужно ничего менять. Только разместите базу SQLite с именем **application.sqlite** в **application/storage/database**. И все.

Конечно, если вы хотите изменить имя базы данных, вам нужно будет поправить SQLite секцию в **application/config/database.php**:

	'sqlite' => array(
	     'driver'   => 'sqlite',
	     'database' => 'your_database_name',
	)

Если ваше приложение получает менее 100000 хитов в день, SQLite вам вполне подойдет. В противном случае, можно использовать MySQL или PostgreSQL.

> **Примечание:** Вы можете использовать хороший sqlite менеджер в виде [Firefox расширения](https://addons.mozilla.org/en-US/firefox/addon/sqlite-manager/).

<a name="server"></a>
## Конфигурирование других баз данных

При использовании MySQL, SQL Server, или PostgreSQL, необходимо изменить соответствующие опции в **application/config/database.php**. В конфигурационном файле вы найдете примерный конфигурации для каждой из систем. вы можете менять их для своих потребностей и установки соединения по умолчанию.

<a name="default"></a>
## Установка имени соединения по умолчанию

Как вы уже, наверное, заметили, каждое соединение с базой данных, определенных в **application/config/database.php**, имеет имя. По умолчанию есть три соединения, которые определены: **SQLite** , **MySQL** , **SQLSRV** и **PgSQL**. Вы можете изменить эти связи имен.Соединение по умолчанию может быть задано с помощью **default** опции:

	'default' => 'sqlite';

Соединение по умолчанию всегда будет использоваться [fluent построителем запросов](/docs/database/fluent). В случае необходимости изменения соединения по умолчанию используйте **Config::set** метод.