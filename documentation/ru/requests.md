# Проверка запросов

## Содержание

- [Работа с URI](#working-with-the-uri)
- [Другие хелперы запросов](#other-request-helpers)

<a name="working-with-the-uri"></a>
## Работа с URI

#### Получение текущего URI запроса:

	echo URI::current();

#### Получение определенного сегмента URI:

	echo URI::segment(1);

#### Возврат значения по умолчанию если сегмент отсутствует (не установлен):

	echo URI::segment(10, 'Foo');

#### Получение полного URI запроса, включая строку параметров:

	echo URI::full();

Иногда вам может понадобиться сравнить текущий URI с заданной строкой, или он начинается с заданной строки.
Примеры:

#### Определение, что URI есть "home":

	if (URI::is('home'))
	{
		// The current URI is "home"!
	}

#### Определение, что URI начинатеся с "docs/":

	if URI::is('docs/*'))
	{
		// The current URI begins with "docs/"!
	}

<a name="other-request-helpers"></a>
## Другие хелперы запросов

#### Получения метода текущего запроса:

	echo Request::method();

#### Доступк к $_SERVER массиву:

	echo Request::server('http_referer');

#### Запрос IP алреса:

	echo Request::ip();

#### Определение, что текущий запрос происходит в HTTPS:

	if (Request::secure())
	{
		// This request is over HTTPS!
	}

#### Определение, что текущий запрос происходит в AJAX:

	if (Request::ajax())
	{
		// This request is using AJAX!
	}

#### Определение, что текущий запрос происходит в Artisan CLI:

	if (Request::cli())
	{
		// This request came from the CLI!
	}
