# Использование кэша

## Содержание

- [Хранение записей](#put)
- [Запрос записей](#get)
- [Удаление записей](#forget)

<a name="put"></a>
## Хранение записей

Сохранять записи в кэше простоо. Просто вызовите метод **put** класса Cache:

	Cache::put('name', 'Taylor', 10);

Первый параметр - это **key** (ключ) кэш-записи. Вы можете использовать этот ключ для запроса записи из кэша. Второй парметр - **value** значение записи кэша. Третий параметр указывает количество минут времени жизни кэша.

Вы можете использовать "вечное" хранение в кэше:

	Cache::forever('name', 'Taylor');

> **Примечание:** Это не обязательно для сериализации объектов при хранении их в кэше.

<a name="get"></a>
## Запрос записей

Извлечение записей из кэша еще более просто, чем сохранение. Это производися при помощи метода **get**.
Укажите ключ который вы запрашиваете:

	$name = Cache::get('name');

По умолчанию, если время жизни записи истекло, или запись не существует, будет возвращен NULL. Тем не менее, вы можете передать другое значение по умолчанию в качестве второго параметра в методе:

	$name = Cache::get('name', 'Fred');

Теперь, метод возвратит "Fred", если записи нет или время ее жизни истекло.

Что делать, если вам нужно значение из базы данных, а элемент кэша не существует? Решение простое. Вы можете передать значение по умолчанию в анонимную функцию метода **get**. Эта функция будет вызвана, если записи кэша нет:

	$users = Cache::get('count', function() {return DB::table('users')->count();});

Давайте пройдем этот пример по шагам.
Представьте, что вы хотите получить количество зарегистрированных пользователей вашего приложения, но, если этого значения нет в кэше, вы хотите сохранить значение по умолчанию в кэше с помощью **remember** метода:

	$users = Cache::remember('count', function() {return DB::table('users')->count();}, 5);

Пойдем дальше. 
Если **count** запись есть в кэше, она будет возвращена. В противном случае результат вызова анонимной функции будет сохранен в кэше на 5 минут **и** будет возвращен методу. Красиво, правда?

Laravel также предоставляет вам простой метод определения наличия записи в кэше - метод **has**:

	if (Cache::has('name'))
	{
	     $name = Cache::get('name');
	}

<a name="forget"></a>
## Удаление записей

Вам нужно избавиться от кэшированного элемента? Без проблем! Просто вставьте имя записи в метод **forget**:

	Cache::forget('name');