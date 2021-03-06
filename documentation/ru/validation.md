# Валидация

## Содержание

- [Основы](#the-basics)
- [Правила валидации](#validation-rules)
- [Запрос сообщений об ошибке](#retrieving-error-messages)
- [Прохождение валидации](#validation-walkthrough)
- [Пользовательские сообщения об ошибках](#custom-error-messages)
- [Пользовательские правила валидации](#custom-validation-rules)

<a name="the-basics"></a>
## Основы

Почти всем интерактивные веб-приложения необходимо проверить вводимые данные. Например, в регистрационная форма, вероятно, потребует пароль для подтверждения. Может быть, адрес электронной почты должен быть уникальным. Проверка данных может быть громоздким процессом. К счастью,только не в Laravel.Класс Validator обеспечивает удивительный набор помощников для проверки, максимально облегчая проверку данных. Давайте рассмотрим пример:

#### Получение массива данных для валидации:

	$input = Input::all();

#### Определение правил валидации данных:

	$rules = array(
		'name'  => 'required|max:50',
		'email' => 'required|email|unique:users',
	);

#### Создание экземпляра Validator и валидация данных:

	$validation = Validator::make($input, $rules);

	if ($validation->fails())
	{
		return $validation->errors;
	}

При наличии свойства *errors* вы получаете доступ к сборщику сообщений, позволяющему легко создавать свои сообщения об ошибках. Конечно же, все правила валидации имеют соощения об ошибках по умолчанию. Стандартные сообщения об ошибках находятся в **language/en/validation.php**.

Теперь вы знакомы с основными правилами использования класса Validator. Вы готовы к исследованию и изучению правил используемых для проверки ваших данных!

<a name="validation-rules"></a>
## Правила валидации

- [Обязательные данные](#rule-required)
- [Alpha, Alpha Numeric, & Alpha Dash](#rule-alpha)
- [Размер](#rule-size)
- [Числовые типы](#rule-numeric)
- [Вхождения и исключения](#rule-in)
- [Подтверждение](#rule-confirmation)
- [Акцептирование](#rule-acceptance)
- [Соответствия и различия](#same-and-different)
- [Регулярные выражения](#regex-match)
- [Уникальность и существование](#rule-unique)
- [Даты](#dates)
- [E-Mail адреса](#rule-email)
- [URL](#rule-url)
- [Загрузки](#rule-uploads)

<a name="rule-required"></a>
### Обязательные данные

#### Проверка на обязательное не пустое значение параметра:

	'name' => 'required'

<a name="rule-alpha"></a>
### Alpha, Alpha Numeric, & Alpha Dash

#### Проверка на наличие только букв:

	'name' => 'alpha'

#### Проверка на наличие только букв и цифр:

	'username' => 'alpha_num'

#### Проверка на наличие только букв, цифр, тире и символа подчеркивания:

	'username' => 'alpha_dash'

<a name="rule-size"></a>
### Размер

#### Проверка на размер строки строчного атрибута, или диапазон значений числового атрибута:

	'name' => 'size:10'

#### Проверка на диапазон значений:

	'payment' => 'between:10,50'

> **Примечание:** Минимум и максимум включены в диапазон.

#### Проверка минимального размера атрибута:

	'payment' => 'min:10'

#### Проверка максимального размера атрибута:

	'payment' => 'max:50'

<a name="rule-numeric"></a>
### Числовые типы

#### Проверка принадлежности атрибута к числовому типу:

	'payment' => 'numeric'

#### Проверка принадлежности атрибута к целочисленному типу:

	'payment' => 'integer'

<a name="rule-in"></a>
### Вхождения и исключения

#### Проверка атрибута на вхождение в массив значений:

	'size' => 'in:small,medium,large'

#### Проверка атрибута на исключкение из массива значений:

	'language' => 'not_in:cobol,assembler'

<a name="rule-confirmation"></a>
### Подтверждение

Правило *confirmed* проверяет, что для данного атрибута есть соответствующее подтверждение * attribute_confirmation *.

#### Проверка атрибута на подтверждение:

	'password' => 'confirmed'

В этом примере Validator проверяет, что параметр *password* удовлетворяет условиям *password_confirmation* из массива валидации. 

<a name="rule-acceptance"></a>
### Акцептирование

Правило *accepted* проверяет параметр на значение *yes* или *1*. Это правило проверяет установку обязательных чекбоксов, таких, как, например, флажок согласия с "Условиями предоставления услуг".

#### Проверка акцептирования:

	'terms' => 'accepted'

<a name="same-and-different"></a>
## Соответствия и различия

#### Проверка, что атрибут такой же как, и сравниваемый другой артибут:

	'token1' => 'same:token2'

#### Проверка на то, что атрибут имеет разное значение:

	'password' => 'different:old_password',

<a name="regex-match"></a>
### Регулярные выражения

Правило *match* проверяет атрибут на удовлетворение регулярному выражению.

#### Поверка на удовлетворение регулярному выражению:

	'username' => 'match:/[a-z]+/';

<a name="rule-unique"></a>
### Уникальность и существование

#### Проверка параметра на уникальность в базе данных:

	'email' => 'unique:users'

В этом примере параметр *email* проверяется на уникальность в таблице *users*. Необходимо проверить уникальность атрибута другого столбца, кроме этого? Нет проблем:

#### Указание другого столбца для проверки:

	'email' => 'unique:users,email_address'

Часто, при обновлении записи, вам нужно использовать правило уникальности, но при этом исключить обновляемую запись. Напрмер, вы хотите дать возможность пользователям изменять свои почтовые адреса. Но, когда запускается правило *unique*, вм нужно пропустить этого пользователя, чтобы не вызвать мнимую ошибку проверки. Это просто:

#### Игнорирование указанного ID:

	'email' => 'unique:users,email_address,10'

#### Проверка на наличие атрибута в указанной базе данных:

	'state' => 'exists:states'

#### Указание имени столбца для правила exists:

	'state' => 'exists:states,abbreviation'

<a name="dates"></a>
### Даты

#### Проверка того, что параметр даты имеет значение до...:

	'birthdate' => 'before:1986-28-05';

#### Проверка того, что параметр даты имеет значение после...:

	'birthdate' => 'after:1986-28-05';

> **Примечание:** Проверка **before** и **after** использует функцию PHP **strtotime**.

<a name="rule-email"></a>
### E-Mail адреса

#### Проверка того, что параметр является E-Mail адресом:

	'address' => 'email'

> **Примечание:** Это правило использует встроенный в PHP метод *filter_var*.

<a name="rule-url"></a>
### URLs

#### Проверка того, что параметр есть URL:

	'link' => 'url'

#### Проверка того, что параметр есть активный URL:

	'link' => 'active_url'

> **Примечание:** Правило *active_url* используетs *checkdnsr* для проверки активности URL.

<a name="rule-uploads"></a>
### Загрузки

Правила *mimes* проверяют, что загружаемый файл соответствует MIME типу. Это правило использует расширение PHP Fileinfo проверяющее содержимое файла и определяющее его тип. Любые расширения файлов, применимые к этому правилу, определяются в *config/mimes.php*.

#### Проверка принадлежности файла определенному типу:

	'picture' => 'mimes:jpg,gif'

> **Примечание:** При проверке не забудьте использовать Input::file() или Input::all().

#### Проверка того, что файл изображение:

	'picture' => 'image'

#### Проверка на размер файла:

	'picture' => 'image|max:100'

<a name="retrieving-error-messages"></a>
## Запрос сообщения об ошибке

Laravel позволяет работать с сообщениями об ошибках с помощью простого класса - сборщика ошибок. После вызова методов *passes* или *fails* экземпляра Validator, вы можете получить доступ к ошибке при помощи свойства *errors*. Сборщик ошибок имеет простые функции для запроса сообщений об ошибках:

#### Определение, что атрибут имеет сообщение об ошибке:

	if ($validation->errors->has('email'))
	{
		// The e-mail attribute has errors...
	}

#### Запрос первого сообщения об ошибке для атрибута:

	echo $validation->errors->first('email');

Вам может понадобиться обернуть авше сообщение об ошибке в HTML тэги. Нет проблем. Вызывая :message place-holder, определите формат вторым параметром метода.

#### Форматирование сообщения об ошибке:

	echo $validation->errors->first('email', '<p>:message</p>');

#### Получение всех сообщений об ошибках для атрибута:

	$messages = $validation->errors->get('email');

#### Форматирование всех сообщений об ошибках для аттрибута:

	$messages = $validation->errors->get('email', '<p>:message</p>');

#### Получение всех сообщений об ошибках для всех атрибутов:

	$messages = $validation->errors->all();

#### Форматирование всех сообщений об ошибках для всех атрибутов:

	$messages = $validation->errors->all('<p>:message</p>');

<a name="validation-walkthrough"></a>
## Прохождение валидации

После того как вы выполнили вашу проверку, нужен простой способ отображения ошибок в представлении. Laravel делает его очень легко. Давайте рассмотрим типичный сценарий. Это может быть определено двумя путями:

	Route::get('register', function()
	{
		return View::make('user.register');
	});

	Route::post('register', function()
	{
		$rules = array(...);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('register')->with_errors($validation);
		}
	});

Отлично! Итак, мы имеем два простых маршрута для формы регистрации. Один для обработки отображения формы, и один для обработки ввода в форму. В POST маршруте мы проводим некоторые проверки на входе. Если проверка не пройдена, будем преадресовывать обратно в регистрационную форму с указанием ошибок и отображения последних в форме.

**Но, обратите внимание, мы явно не связываем ошибки с целью в нашем GET маршруте**. Тем не менее, переменная ошибки будет доступна в представлении. Laravel разумно определяет, есть ли ошибки в работе сессии, и если они есть, присоединяет сообщения к представлению. Если ошибок нет, пустой контейнер сообщения об ошибке все равно будет присоединен к представлению. В представлении всегда будет доступен контейнер сообщений об ошибках. Нам нравится облегчать вам жизнь.

<a name="custom-error-messages"></a>
## Пользовательские сообщения об ошибках

Хотите использовать собственное сообщение об ошибке? Может быть, вы даже хотите использовать пользовательские сообщения об ошибке для данного атрибута и правила. В любом случае, класс Validator позволяет легко это сделать.

#### Создание массива собственных сообщений об ошибках для Validator:

	$messages = array(
		'required' => 'The :attribute field is required.',
	);

	$validation = Validator::make(Input::get(), $rules, $messages);

Отлично! Теперь наши пользовательских сообщения будет использоваться всегда при проверке. Но, что за выражение **:attribute** в нашем сообщении. Для облегчения вашей жизни, класс Validator заменяет **:attribute** на атрибут, ввод которго вызвал ошибку. Он даже удалит символ подчеркивания из имени атрибута.
Вы также можете использовать **:other**, **:size**, **:min**, **:max**, и **:values** заполнители для конструирования ваших сообщений об ошибках.

#### Примеры пользовательских сообщений об ошибках:

	$messages = array(
		'same'    => 'The :attribute and :other must match.',
		'size'    => 'The :attribute must be exactly :size.',
		'between' => 'The :attribute must be between :min - :max.',
		'in'      => 'The :attribute must be one of the following types: :values',
	);

Что, если вам нужно определить необходимое сообщению, но только для атрибута электронной почты? Без проблем. Просто укажите сообщение, используя **attribute_rule**  именование:

#### Определение сообщения для конктретного атрибута:

	$messages = array(
		'email_required' => 'We need to know your e-mail address!',
	);

В данном примере, пользовательское сообщение об ошибке будет использовано только для атрибута email, в остальных случаях будут использоваться стандартные сообщения.

В то же время, если вы используете много собственных сообщений об ошибках, указание всех их в коде может сделать его громоздким и неудобным. По этой причине есть возможность определить собственный массив в языковом файле:

#### Добавление собственного массива в языковый файл:

	'custom' => array(
		'email_required' => 'We need to know your e-mail address!',
	)

<a name="custom-validation-rules"></a>
## Собственные правила валидации

Laravel предоставляет ряд мощных правила проверки. Тем не менее, вы можете создать свои собственные. Есть два простых способа создания правил проверки. И тот и другой надежны в использовании. Вам остается только выбрать более подходящий для вашего проекта.

#### Регистрация собственного валидационного правила:

	Validator::register('awesome', function($attribute, $value, $parameters)
	{
	    return $value == 'awesome';
	});

В этом примере мы зарегистрировали новые правила проверки для класса Validator. Это правило получает три параметра. Во-первых, это имя проверяемого атрибута, второй - значение проверяемого атрибута, а третий представляет собой массив из параметров, которые были заданы для правила.

Так выглядит вызов вашего правила:

	$rules = array(
    	'username' => 'required|awesome',
	);

Конечно, вам нужно определить сообщение об ошибке для нового правила. Вы можете сделать это либо в специальных сообщениях массива:

	$messages = array(
    	'awesome' => 'The attribute value must be awesome!',
	);

	$validator = Validator::make(Input::get(), $rules, $messages);

или, добавив запись для правила в **language/en/validation.php**:

	'awesome' => 'The attribute value must be awesome!',

Как уже упоминалось выше, вы даже можете указать и получить список параметров в пользовательском правиле:

	// При построении правила...

	$rules = array(
	    'username' => 'required|awesome:yes',
	);

	// В правиле...

	Validator::register('awesome', function($attribute, $value, $parameters)
	{
	    return $value == $parameters[0];
	}

В данном примере параметр аргументов вашего правила проверки будет получать массив, содержащий один элемент: "да".

Еще один способ для создания и хранения пользовательских правил проверки заключается в расширении класса Validator. Причем благодаря пространствам имен в Laravel этот класс может расширить сам себя. Тем самым вы создаете новую версию валидатора, который имеет все ранее существующие функции в сочетании с новыми дополнениями. Вы даже можете выбрать, чем заменить некоторые из методов по умолчанию, если вы хотите. Давайте посмотрим на примере:

Сначала, создаете класс **Validator** который наследует класс **Laravel\Validator** и размещаете его в **application/libraries**:

#### Определение собственного класса:

	<?php

	class Validator extends Laravel\Validator {}

Далее, удалите алиас Validator из **config/application.php**. Это необходимо для исключения конфликта классов.

Теперь, добавим наше правило "awesome" и определим его в новом классе:

#### Добавление нового правила:

	<?php

	class Validator extends Laravel\Validator {

	    public function validate_awesome($attribute, $value, $parameters)
	    {
	        return $value == 'awesome';
	    }

	}

Обратите внимание, что метод validate_awesom именуется согласно соглашению имен. Т.е. для правила "awesome" метод должен иметь имя "validate_awesome". Это один из многих способов расширения класса Validator. Класс Validator просто требует возврата значения "true" или "false". И все!

Имейте в виду, что вам еще нужно создать специальное сообщение для правил проверки, которые вы создаете. Метод для этого так же независим от того, как вы определяете правила!
