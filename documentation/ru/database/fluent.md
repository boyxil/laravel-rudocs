# Fluent конструктор запросов

## Содержание

- [Основы](#the-basics)
- [Получение записей](#get)
- [Построение Where критериев](#where)
- [Вложенные Where критерии](#nested-where)
- [Динамические Where критерии](#dynamic)
- [Связывание таблиц](#joins)
- [Сортировка результатов](#ordering)
- [Ограничения и смещения](#limit)
- [Агрегатирование](#aggregates)
- [Выражения](#expressions)
- [Вставка записей](#insert)
- [Изменение записей](#update)
- [Удаление записей](#delete)

## Основы

Fluent конструктор запросов является мощным интерфейсом Laravel для построения SQL запросов и работы с базой данных. Все запросы используют подготовленные выражения и защищены от SQL инъекций.

Вы можете начать работать с fluent используя метод **table** класса DB.
You can begin a fluent query using the **table** method on the DB class. Просто укажите таблицу для запроса:

	$query = DB::table('users');

Теперь вы подсоединены к базе "users" и можете использовать Fluent. Вы можете запрашивать, вставлять, обновлять, или удалять записи из таблиц.

<a name="get"></a>
## Запрос записей

#### Получение массива записей из базы:

	$users = DB::table('users')->get();

> **Примечание:** Метод **get** возвращает массив объектов со свойствами, соотвествующими столбцам базы.

#### Получение первой записи из базы:

	$user = DB::table('users')->first();
	
#### Получение записи по ключу:

	$user = DB::table('users')->find($id);

> **Примечание:** Если результат не найдется, метод **first** вернет NULL. Метод **get** в таких случаях возвращает пустой массив.

#### Получение значения из одного столбца базы данных:

	$email = DB::table('users')->where('id', '=', 1)->only('email');

#### Выбор только определенных столбцов из базы данных:

	$user = DB::table('users')->get(array('id', 'email as user_email'));

#### Выбор различных результатов из базы данных:

	$user = DB::table('users')->distinct()->get();

<a name="where"></a>
## Построение Where критериев

### where и or\_where

Есть различные методы, чтобы помочь вам в создании where критериев. Самый основной из этих методов, where и or_where методами. Вот как их использовать:

	return DB::table('users')
		->where('id', '=', 1)
		->or_where('email', '=', 'example@gmail.com')
		->first();

Вы, конечно, не ограничитесь только проверкой равенства. Вы можете использовать **greater-than**, **less-than**, **not-equal**, и **like**:

	return DB::table('users')
		->where('id', '>', 1)
		->or_where('name', 'LIKE', '%Taylor%')
		->first();

Подводя итог, **where** метод добавит в запрос с использованием AND условием, в то время как **or_where** метод будет использовать OR условие.

### where\_in, where\_not\_in, or\_where\_in, и or\_where\_not\_in

Набор методов **where_in** позволяет легко строить запросы для получения массив значений:

	DB::table('users')->where_in('id', array(1, 2, 3))->get();

	DB::table('users')->where_not_in('id', array(1, 2, 3))->get();

	DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_in('id', array(1, 2, 3))
		->get();

	DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_not_in('id', array(1, 2, 3))
		->get();

### where\_null, where\_not\_null, or\_where\_null, и or\_where\_not\_null

Набор **where_null** методов делает проверку на NULL соответствия:

	return DB::table('users')->where_null('updated_at')->get();

	return DB::table('users')->where_not_null('updated_at')->get();

	return DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_null('updated_at')
		->get();

	return DB::table('users')
		->where('email', '=', 'example@gmail.com')
		->or_where_not_null('updated_at')
		->get();

<a name="nested-where"></a>
## Вложенные Where критерии

Для группировки вложенных WHERE можнои спользовать анонимную функцию с **where** или **or_where** методами:

	$users = DB::table('users')
		->where('id', '=', 1)
		->or_where(function($query)
		{
			$query->where('age', '>', 25);
			$query->where('votes' '>', 100);
		})
		->get();

Этот пример создает запрос вида:

	SELECT * FROM "users" WHERE "id" = ? OR ("age" > ? AND "votes" > ?)

<a name="dynamic"></a>
## Динамические Where критерии

Динамические методы **where** - чудесный способ улучшить читабельность кода. Например:

	$user = DB::table('users')->where_email('example@gmail.com')->first();

	$user = DB::table('users')->where_email_and_password('example@gmail.com', 'secret');

	$user = DB::table('users')->where_id_or_name(1, 'Fred');


<a name="joins"></a>
## Связывание таблиц

Используйте **join** и **left\_join** методы:

	DB::table('users')
		->join('phone', 'users.id', '=', 'phone.user_id')
		->get(array('users.email', 'phone.number'));

Присоединяемая таблица передается в качестве первого параметра. Оставшиеся три параметра используются для построения связывания.

Раз вы знаете, как использовать **join**, вы знаете как использовать **left_join**. Сигнатура такая же:

	DB::table('users')
		->left_join('phone', 'users.id', '=', 'phone.user_id')
		->get(array('users.email', 'phone.number'));

Вы можете также определить множественные критерии для **ON** критериев использованием анонимой функции в качестве второго параметра связывания:

	DB::table('users')
		->join('phone', function($join)
		{
			$join->on('users.id', '=', 'phone.user_id');
			$join->or_on('users.id', '=', 'phone.contact_id');
		})
		->get(array('users.email', 'phone.numer'));

<a name="ordering"></a>
## Сортировка результатов

Для сортировки используется метод **order_by**. Применение очень простое:

	return DB::table('users')->order_by('email', 'desc')->get();

Вы можете использовать множественную сортировку:

	return DB::table('users')
		->order_by('email', 'desc')
		->order_by('name', 'asc')
		->get();

<a name="limit"></a>
## Ограничения и смещения

Для использования **LIMIT** при ограничении количества записей применяется  **take** метод:

	return DB::table('users')->take(10)->get();

Для установки **OFFSET** запроса используйте **skip** метод:

	return DB::table('users')->skip(10)->get();

<a name="aggregates"></a>
## Агрегатирование

Требуются **MIN**, **MAX**, **AVG**, **SUM**, или **COUNT** значения? Вставьте их в запрос:

	$min = DB::table('users')->min('age');

	$max = DB::table('users')->max('weight');

	$avg = DB::table('users')->avg('salary');

	$sum = DB::table('users')->sum('votes');

	$count = DB::table('users')->count();

С использованием **WHERE**:

	$count = DB::table('users')->where('id', '>', 10)->count();

<a name="expressions"></a>
## Выражения

Иногда вам может потребоваться установить значение столбца в функции SQL, такие как **NOW()**. Обычно ссылки на **NOW()**, автоматически обрамляются в кавычки и скрываются. Для предотвращения этого используют метод **raw** класса **DB**. Вот как это выглядит:

	DB::table('users')->update(array('updated_at' => DB::raw('NOW()')));

**Raw** метод  указывает запросу инжектировать содержимое выражения в запрос в виде строки, а не с заданными параметрами. Например, вы можете использовать выражения для инкрементирования значения столбца:

	DB::table('users')->update(array('votes' => DB::raw('votes + 1')));

Удобные методы предлагаются **increment** и **decrement**:

	DB::table('users')->increment('votes');

	DB::table('users')->decrement('votes');

<a name="insert"></a>
## Вставка записей

**Insert** метод заведует вставкой массива значений. Он возвращает **false** или **true**, индицируя успешеность запроса:

	DB::table('users')->insert(array('email' => 'example@gmail.com'));

Нужно вставить запись с автоинкрементированием ID? Используйте **insert\_get\_id** методы:

	$id = DB::table('users')->insert_get_id(array('email' => 'example@gmail.com'));

> **Примечание:** Методы **insert\_get\_id** ожидают имя автоинкрементируемого столбца "id".

<a name="update"></a>
## Изменение записей

Для изменения записи просто передайте массив методу **update**:

	$affected = DB::table('users')->update(array('email' => 'new_email@gmail.com'));

Для изменения нескольких записей добавьте **WHERE** критерий перед **update** методом:

	$affected = DB::table('users')
		->where('id', '=', 1)
		->update(array('email' => 'new_email@gmail.com'));

<a name="delete"></a>
## Удаление записей

Для удаления используется **delete** метод:

	$affected = DB::table('users')->where('id', '=', 1)->delete();

Хотите быстро удалить запись по ID? Нет проблем. Вставьте ID в метод **delete**:

	$affected = DB::table('users')->delete(1);
