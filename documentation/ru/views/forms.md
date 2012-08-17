# Создание форм

## Содержание

- [Открытие формы](#opening-a-form)
- [CSRF защита](#csrf-protection)
- [Ярлыки (labels)](#labels)
- [Текст, текстовое поле, поле пароля и скрытые поля](#text)
- [Checkboxes и Radio кнопки](#checkboxes-and-radio-buttons)
- [Выпадающие списки](#drop-down-lists)
- [Кнопки](#buttons)
- [Пользовательские макросы](#custom-macros)

> **Примечание:** Все данные в полях формы фильтруются методом HTML::entities.

<a name="opening-a-form"></a>
## Открытие формы

#### Открытие POST формы в текущем URL:

	echo Form::open();

#### Открытие формы с данным URI м указанием метода запроса:

	echo Form::open('user/profile', 'PUT');

#### Открытие POST формы в HTTPS:

	echo Form::open_secure('user/profile');

#### Установка HTML атрибутов формы:

	echo Form::open('user/profile', 'POST', array('class' => 'awesome'));

#### Открытие формы для загрузки файлов:

	echo Form::open_for_files('users/profile');

#### Открытие формы для загрузки файлов в HTTPS:

	echo Form::open_secure_for_files('users/profile');

#### Закрытие формы:

	echo Form::close();

<a name="csrf-protection"></a>
## CSRF защита

Laravel обеспечивает простой способ защиты приложения от межсайтовой подделки запроса. Во-первых, случайный токен помещается в ваш сеанс пользователя. Не переживайте, это делается автоматически. Затем, используется токен метод для создания скрытого поля ввода формы, содержащего случайный токен на форме:

#### Генерация скрытого поля со случайным CSRF токеном:

	echo Form::token();

#### Присоединение CSRF фильтра к маршруту:

	Route::post('profile', array('before' => 'csrf', function()
	{
		//
	}));

#### Получение строки CSRF токена:

	$token = Session::token();

> **Примечание:** Для использования CSRF защиты активируйте поддержку сессий (просто в **application/config/session.php** включите **Session Driver**). Заметьте, что драйвер 'cookie' включен по умолчанию. Вообще, работа с CSRF включена по умолчанию и требует минимального вмешательства.

*Рекомендуется прочитать:*

- [Фильтры маршрутов](/docs/routing#filters)
- [Cross-Site Request Forgery](http://en.wikipedia.org/wiki/Cross-site_request_forgery)

<a name="labels"></a>
## Ярлыки (labels)

#### Генерация ярлыка:

	echo Form::label('email', 'E-Mail Address');

#### Установка HTML атрибутов:

	echo Form::label('email', 'E-Mail Address', array('class' => 'awesome'));

> **Примечание:** После создания ярлыка любой элемент формы с таким же именем автоматически получит такой же атрибут ID.

<a name="text"></a>
## Текст, текстовое поле, поле пароля и скрытые поля

#### Генерация текстового элемента ввода:

	echo Form::text('username');

#### Генерация текстового элемента ввода со знчением по умолчанию:

	echo Form::text('email', 'example@gmail.com');

> **Примечание:** *hidden*(скрытый) и *textarea* методы имеют аналогичные методу *text* сигнатуры. Получите три метода по цене одного!!

#### Генерация элемента ввода пароля:

	echo Form::password('password');

<a name="checkboxes-and-radio-buttons"></a>
## Checkboxes и Radio кнопки

#### Генерация checkbox:

	echo Form::checkbox('name', 'value');

#### Генерация checkbox со значением по умолчанию:

	echo Form::checkbox('name', 'value', true);

> **Note:** Метод *radio* имеет такую же сигнатуру, как и метод *checkbox*. Два в одном!

<a name="drop-down-lists"></a>
## Выпадающие списки

#### Генерация выпадающего списка из массива элементов:

	echo Form::select('size', array('L' => 'Large', 'S' => 'Small'));

#### Генерация выпадающего списка из массива элементов с применением значения по умолчанию:

	echo Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S');

<a name="buttons"></a>
## Кнопки

#### Генерация submit кнопки:

	echo Form::submit('Click Me!');

> **Примечание:** Если вам нужен **button** 'элемент, используйте метод button, он имеет такую же сигнатуру.

<a name="custom-macros"></a>
## Пользовательские макросы

Пользовательские макросы легко объявляются при помощи хелпера "macros". Как всегда, сначала регистрируете макрос при помощи закрытой функции, затем просто вызываете его по имени.

#### Регистрация макроса формы:

	Form::macro('my_field', function()
	{
		return '<input type="awesome">';
	});

И теперь вызов по имени:

#### Вызов макроса формы:

	echo Form::my_field();
