# Маршрутизация

## Содержание

- [Основы](#the-basics)
- [Wildcards (маски маршрутов)](#wildcards)
- [Событие 404](#the-404-event)
- [Фильтры](#filters)
- [Паттерны в фильтрах](#pattern-filters)
- [Глобальные фильтры](#global-filters)
- [Групповая маршрутизация](#route-groups)
- [Именные маршруты](#named-routes)
- [HTTPS маршруты](#https-routes)
- [Маршруты пакетов](#bundle-routes)
- [Маршруты контроллеров](#controller-routing)
- [CLI тестирование маршрутов](#cli-route-testing)

<a name="the-basics"></a>
## Основы

Laravel использует все последние возможноси PHP 5.3 для построения простых и эффективных маршрутов. Это важно для простого построения  как API, так и сложного веб-приложения. Маршруты обычно определяются в **application/routes.php**.

В отличие от многих других фреймворков в Laravel логику приложения можно строить двумя способами. В то время как контроллеры являются наиболее распространенным способом реализации логики приложения, логику можно релизовать прямо в маршруте. Это **особенно** удобно для маленьких сайтов, включающих несколько не связанных между собой страниц, или имеющих небольшое количество контроллеров, также не связанных между собой.

В следующем примере первый параметр - это маршрут, который регистрируется. Второй параметр - функция, реализующая логику маршрута.
Маршруты определяются без "слэша". Единственное исключение - маршрут по умолчанию, представленный **только одним "слэшем"**.

> **Примечание:** Маршруты применяются в порядке их регистрации (указания в **routes.php**), поэтому **общие ("catch-all")** маршруты должны находиться в самом конце перечня маршрутов файла **routes.php**.

#### Регистрация маршрута, отвечающего на запрос "GET /":

	Route::get('/', function()
	{
		return "Hello World!";
	});

#### Регистрация маршрута, отвечающего на любые HTTP запросы (GET, POST, PUT, and DELETE):

	Route::any('/', function()
	{
		return "Hello World!";
	});

#### Регистрация маршрутов для других методов запросов:

	Route::post('user', function()
	{
		//
	});

	Route::put('user/(:num)', function($id)
	{
		//
	});

	Route::delete('user/(:num)', function($id)
	{
		//
	});

**Регистрация маршрута одиночного URI для разных запросов:**

	Router::register(array('GET', 'POST'), $uri, $callback);

<a name="wildcards"></a>
## Wildcards (маски маршрутов)

#### Определение сегмента URI с любым доролнением, содержащим только цифры:

	Route::get('user/(:num)', function($id)
	{
		//
	});

#### Определение сегмента URI с любым дополнением, содержащим любые разрешенные символы:

	Route::get('post/(:any)', function($title)
	{
		//
	});

#### Дополнение URI возможным дополнительным сегментом:

	Route::get('page/(:any?)', function($page = 'index')
	{
		//
	});

<a name="the-404-event"></a>
## Событие 404

Если запрос, полученный приложением, не найден в перечне маршрутов, вызывается событие **404**. Вы можете переопределить обработчик этого события в файле **application/routes.php**.

#### Обработка события 404 по умолчанию:

	Event::listen('404', function()
	{
		return Response::error('404');
	});

Вы можете свободно определить любые маршруты и события в соответствии с требованиями вашего приложения!

*Дополнительно о событиях:*

- *[События](/docs/events)*

<a name="filters"></a>
## Фильтры

Фильтры маршрутов выполняются **до (before)** или **после (after)** выполнения собственно маршрута. Если "before" возвращает значение, это значение рассматривается как ответ на запрос и маршрут далее не выполняется, что удобно, например, для организации аутентификации, и т.д. Фильтры обычно определяются в **application/routes.php**.

#### Регистрация фильтра:

	Route::filter('filter', function()
	{
		return Redirect::to('home');
	});

#### Привязка фильтра к маршруту:

	Route::get('blocked', array('before' => 'filter', function()
	{
		return View::make('blocked');
	}));

#### Привязка "after" фильтра к маршруту:

	Route::get('download', array('after' => 'log', function()
	{
		//
	}));

#### Привязка нескольких фильтров к маршруту:

	Route::get('create', array('before' => 'auth|csrf', function()
	{
		//
	}));

#### Передача параметров в маршрут:

	Route::get('panel', array('before' => 'role:admin', function()
	{
		//
	}));

<a name="pattern-filters"></a>
## Паттерны в фильтрах

При необходимости вы можете привязать фильтр ко всем запросам, которые начинаются с определенного URI. Например, вы можете привязать фильтр авторизации для всех запросов, начинающихся с "admin". Ниже показано, как это выглядит:

#### Определение фильтра на базе URI паттерна:

	Route::filter('pattern: admin/*', 'auth');

<a name="global-filters"></a>
## Глобальные фильтры

Laravel имеет два глобальных фильтра, выполняющихся **до** и **после** каждого запроса вашего приложения. Вы их можете найти в **application/routes.php**. Эти фильтры удобны для запуска пакетов (bundles) или внесения глобальных настроек.

> **Примечание:** **after** фильтр принимает **Response** объект текущего запроса.

<a name="route-groups"></a>
## Групповая маршрутизация

Групповая маршрутизация позволяет передавать набор атрибутов для группы маршрутов, что позволит вам сохранить ваш код чистым и удобным.

	Route::group(array('before' => 'auth'), function()
	{
		Route::get('panel', function()
		{
			//
		});

		Route::get('dashboard', function()
		{
			//
		});
	});

<a name="named-routes"></a>
## Именные маршруты

Постоянная генерация URL или перенаправления, используя маршруты может принести неудобства при значительных изменениях.Присвоение маршруту имени является удобным средством для решения проблем с маршрутами вашего приложения.Когда маршрут будет изменен, по его имени автоматически сгенерируются все необходимые ссылки.

#### Присвоение имени маршруту:

	Route::get('/', array('as' => 'home', function()
	{
		return "Hello World";
	}));

#### Присвоение URL именному маршрута:

	$url = URL::to_route('home');

#### Перенаправление на именной маршрут:

	return Redirect::to_route('home');

Однажды присвоив имя маршруту,вы легко можете проверить, принадлежит ли действующий запрос именному маршруту. 

#### Проверка принадлежности запроса именному маршруту:

	if (Request::route()->is('home'))
	{
		// The "home" route is handling the request!
	}

<a name="https-routes"></a>
## HTTPS маршруты

При определении маршрута вы можете использовать атрибут HTTPS для указания использования защищенного протокола.

#### Определение HTTPS маршрута:

	Route::get('login', array('https' => true, function()
	{
		return View::make('login');
	}));

#### Использование "secure" метода:

	Route::secure('GET', 'login', function()
	{
		return View::make('login');
	});

<a name="bundle-routes"></a>
## Маршруты пакетов

В Laravel бандлами называют модульную систему пакетов. Бандлы легко могут быть настроены на обработку запросов вашего приложения. Подробнее об этом рассказано в разделе [Бандлы](/docs/bundles).Пока что, прочитайте этот раздел для того, чтобы просто знать, что функциональность маршрутов в бандлах обеспечивается не только в стандартной настройке маршрутов, но последние также могут быть зарегистрированы в пределах бандла..

Итак, сначала создайте в директории **ваш_сайт/bundles** директорию "admin" - в этой директории теперь находится ваш бандл "admin". После этого откройте **application/bundles.php** и добавьте следущий код:

#### Регистрация бандла для обработки маршрута:

	return array(

		'admin' => array('handles' => 'admin'),

	);

Заметили опцию **handles** в массиве конфигурации бандла? Это указывает Laravel загружать Admin бандл на все запросы, начинающиеся с "admin".

Теперь вы готовы зарегистрировать некоторые маршруты вашего бандла, создайте и откройте **routes.php** в корневой директории вашего бандла и добавьте следующее:

#### Регистрация корневого маршрута в бандле:

	Route::get('(:bundle)', function()
	{
		return 'Welcome to the Admin bundle!';
	});

Рассмотрим этот пример. Что означает **(:bundle)**? Он заменяется значением **handles** ключа использованного при регистрации бандла. Это сохраняет ваш код [D.R.Y.](http://en.wikipedia.org/wiki/Don't_repeat_yourself) от изменений в случае замены корня приложения! Отлично, не правда ли?

И конечно же, вы можете использовать **(:bundle)** для всех маршрутов, а не только для регистрации корневого маршрута.

#### Регистрация маршрутов в бандле "your_bundle/routes.php":

	Route::get('(:bundle)/panel', function()
	{
		return "I handle requests to admin/panel!";
	});

<a name="controller-routing"></a>
## Маршруты контроллеров

Контроллеры предлагают другой путь для управления логикой приложения. Если вы не знакомы с контроллерами, вам стоит прочитать [раздел о контроллерах](/docs/controllers) и вернуться к прочтению этого раздела.

Важно знать, что все маршруты в Laravel должны быть четко определены, в том числе маршруты в контроллерах. Это означает, что методы контроллера, которые не были зарегистрированы в **не будут** доступны.
Можно автоматически зарегистрировать все методы в контроллере, используя контроллер регистрации маршрутов контроллеров.
Маршруты контроллеров обычно определяются в **application/routes.php**.

Скорее всего, вы захотите определить автоматически **все** маршруты **всех** контроллеров приложения из вашей директории контроллеров. Нет ничего проще:

#### Регистрация всех маршрутов контроллеров приложения:

	Route::controller(Controller::detect());

Метод **Controller::detect** просто возвращает массив всех конроллеров приложения.

Если вы хотите зарегистрировать все маршруты вашего бандла, просто внесите имя бандла в метод. Если бандла не существует, будет просмотрена директория контоллеров.

#### Регистрация всех контроллеров бандла "admin":

	Route::controller(Controller::detect('admin'));

#### Регистрация контроллера "home" при помощи Router:

	Route::controller('home');

#### Регистрация некоторых контроллеров при помощи Router:

	Route::controller(array('dashboard.panel', 'admin'));

Когда контроллер зарегистрирован, вы можете обращаться к его методам при помощи простого URI:

	http://localhost/controller/method/arguments

Это соглашение аналогично используемым в CodeIgniter и других популярных фреймворках, где первый сегмент определяет мя контроллера, второй - это метод, и следующие за ними сегменты передаются в метод в виде параметров.
Если сегмент метода не указан, используется метод "index".

Это соглашение может не подходить в некоторых ситуациях, тогда вы можете явно указать маршрут URI с помощью простого, интуитивно понятного синтаксиса.

#### Регистрация маршрута, указывающего на конктретную точку входа (action) в контроллер:

	Route::get('welcome', 'home@index');

#### Регистрация маршрута с использованием фильтра и вызовом метода в контроллере:

	Route::get('welcome', array('after' => 'log', 'uses' => 'home@index'));

#### Регистрация именного маршрута и вызовом метода в контроллере:

	Route::get('welcome', array('as' => 'home.welcome', 'uses' => 'home@index'));

<a name="cli-route-testing"></a>
## CLI тестирование маршрутов

Вы можете проверить ваши маршруты, используя "Artisan" CLI. Просто укажите метод запроса и URI, который вы хотите использовать. Arisan вернет дамп маршрута в виде var_dump.

#### Вызов маршрута посредством Artisan CLI:

	php artisan route:call get api/user/1
