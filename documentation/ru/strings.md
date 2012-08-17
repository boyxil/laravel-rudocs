# Работа со строками

## Содержание

- [Капитализация и др.](#capitalization)
- [Ограничения на слова и символы](#limits)
- [Генерация случайных строк](#random)
- [Преобразование во множественную и единственную формы](#singular-and-plural)
- [Линотипирование](#slugs)

<a name="capitalization"></a>
## Капитализация и др.

Класс **Str** предоставляет три способа манипулирования регистрами символов в строке: **upper**, **lower**, и **title**. Это более "интеллигентная" версия PHP [strtoupper](http://php.net/manual/en/function.strtoupper.php), [strtolower](http://php.net/manual/en/function.strtolower.php), и [ucwords](http://php.net/manual/en/function.ucwords.php) методов. 
Более "интеллигентная", потому что поддерживает UTF-8, если [multi-byte string](http://php.net/manual/en/book.mbstring.php) PHP установлено на сервер. Использование:

	echo Str::lower('I am a string.');

	echo Str::upper('I am a string.');

	echo Str::title('I am a string.');

<a name="limits"></a>
## Ограничения слов и символов

#### Ограничение символов в строке:

	echo Str::limit($string, 10);

#### Ограничение слов в строке:

	echo Str::words($string, 10);

<a name="random"></a>
## Генерация случайных строк

#### Генерация случайной строки из буквенно-цифровых символов:

	echo Str::random(32);

#### Генерация случайной строки из буквенных символов:

	echo Str::random(32, 'alpha');

<a name="singular-and-plural"></a>
## Преобразование во множественную и единственную формы

Класс String имеет возможность трансформирования строк из единственной во множественную формы, и наоборот.

#### Получение множественной формы слова:

	echo Str::plural('user');

#### Получение единственной формы слова:

	echo Str::singular('users');

#### Получение формы множественного числа, если данное значение больше единицы:

	echo Str::plural('comment', count($comments));

<a name="slugs"></a>
## Линотипирование

#### Генерация дружественных URL:

	return Str::slug('My First Blog Post!');
>**Примечание** На выходе получим **my-first-blog-post**

#### Генерация дружественных URL с определенным разделителем:

	return Str::slug('My First Blog Post!', '_');
>**Примечание** На выходе получим **my_first_blog_post**

