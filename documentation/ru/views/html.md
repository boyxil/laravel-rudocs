# Building HTML

## Content

- [Сущности](#entities)
- [Скрипты и таблицы стилей](#scripts-and-style-sheets)
- [Ссылки](#links)
- [Ссылки на именные маршруты](#links-to-named-routes)
- [Ссылки на действия контроллеров](#links-to-controller-actions)
- [Mail-To ссылки](#mail-to-links)
- [Изображения](#images)
- [Списки](#lists)
- [Пользовательские макросы](#custom-macros)

<a name="entities"></a>
## Сущности

При отображении пользовательского ввода на странице, важно конвертировать все символы, имеющие определение в HTML в представляемые сущности HTML.

Например,  < символ должен быть конвертирован в сущность HTML. Конвертация HTML в их сущность защищает ваше приложение от cross-site скриптов:

#### Конвертация строки в сущность:

	echo HTML::entities('<script>alert('hi');</script>');

#### Оспользование "e" общего хелпера:

	echo e('<script>alert('hi');</script>');

<a name="scripts-and-style-sheets"></a>
## Скрипты и таблицы стилей

#### Генерация ссылки на JavaScript файл:

	echo HTML::script('js/scrollTo.js');

#### Генерация ссылки на CSS файл:

	echo HTML::style('css/common.css');

#### Генерация ссылки на CSS файл  с использованием медиа типа:

	echo HTML::style('css/common.css', 'print');

*Рекомендуем к прочтению:*

- *[Управление ресурсами](/docs/views/assets)*

<a name="links"></a>
## Ссылки

#### Генерация линка из URI:

	echo HTML::link('user/profile', 'User Profile');

#### Генерация линка HTTPS:

	echo HTML::secure_link('user/profile', 'User Profile');

#### Генерация линка с дополнительными атрибутами:

	echo HTML::link('user/profile', 'User Profile', array('id' => 'profile_link'));

<a name="links-to-named-routes"></a>
## Ссылки на именные маршруты

#### Генерация линка на именной маршрут:

	echo HTML::link_to_route('profile');

#### Генерация линка на именные маршруты с использованием маски маршрута:

	$url = HTML::link_to_route('profile', array($username));

*Рекомендуем к прочтению:*

- *[Именные маршруты](/docs/routing#named-routes)*

<a name="links-to-controller-actions"></a>
## Ссылки на действия контроллеров

#### Генерация ссылки на действие контроллера:

	echo HTML::link_to_action('home@index');

### Генерация ссылки на действие контроллера с передачей маски параметров:

	echo HTML::link_to_action('user@profile', array($username));

<a name="mail-to-links"></a>
## Mail-To ссылки

'MailTo' метод обфускации защищает данный почтовый адрес от сканирования ботами.

#### Создание ссылки mail-to:

	echo HTML::mailto('example@gmail.com', 'E-Mail Me!');

#### Создание ссылки mail-to с использование e-mail адреса в качестве текста ссылки:

	echo HTML::mailto('example@gmail.com');

<a name="images"></a>
## Изображения

#### Генерация тэга изображения HTML:

	echo HTML::image('img/smile.jpg', $alt_text);

#### Генерация тэга изображения HTML с дополнительными атрибутами:

	echo HTML::image('img/smile.jpg', $alt_text, array('id' => 'smile'));

<a name="lists"></a>
## Списки

#### Создание списка с массивом элементов:

	echo HTML::ol(array('Get Peanut Butter', 'Get Chocolate', 'Feast'));

	echo HTML::ul(array('Ubuntu', 'Snow Leopard', 'Windows'));

<a name="custom-macros"></a>
## Пользовательские макросы

Очень прото можно определить собственный макрос HTML класса. Сначала зарегистрируйте его закрытой фнукцией:

#### Регистрация HTML макроса:

	HTML::macro('my_element', function()
	{
		return '<article type="awesome">';
	});

Теперь вы его можете вызвать по имени:

#### Вызов пользовательского HTML макрос:

	echo HTML::my_element();
