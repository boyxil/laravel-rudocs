# Генерация URL

## Содержание

- [Основы](#the-basics)
- [URL маршрутов](#urls-to-routes)
- [URL действий контроллеров](#urls-to-controller-actions)
- [URL ресурсов](#urls-to-assets)
- [URL хелперов](#url-helpers)

<a name="the-basics"></a>
## Основы

#### Поучение корневого URL приложения:

	$url = URL::base();

#### Генерация URL, относительного к корневому URL:

	$url = URL::to('user/profile');

#### Генерация HTTPS URL:

	$url = URL::to_secure('user/login');

#### Получение текущего URL:

	$url = URL::current();

#### Получение текущего URL включая строку запроса:

	$url = URL::full();

<a name="urls-to-routes"></a>
## URL маршрутов

#### Генерация URL именного маршрута:

	$url = URL::to_route('profile');

Может онадобиться сгенерировать URL для именного маршрута с передачей параметра в маску маршрута.

#### Генерация URL именного маршрута с передачей параметра маски:

	$url = URL::to_route('profile', array($username));

*Рекомендуем прочитать:*

- [Именные маршруты](/docs/routing#named-routes)

<a name="urls-to-controller-actions"></a>
## URL действий контроллеров

#### Генерация URL действия контроллера:

	$url = URL::to_action('user@profile');

#### Генерация URL действия контроллера с передачей параметра маски:

	$url = URL::to_action('user@profile', array($username));

<a name="urls-to-assets"></a>
## URL ресурсов

URL, сгенерированый для ресурса, не будет содержать значение опции "application.index".

#### Генерация URL для русурса:

	$url = URL::to_asset('js/jquery.js');

<a name="url-helpers"></a>
## URL хелперы

Несколько глобальных функций, призванных облегчить вам жизнь при создании чистого и удобного кода:

#### Генерация URL относительно базового URL:

	$url = url('user/profile');

#### Генерация URL ресурса:

	$url = asset('js/jquery.js');

#### Генерация URL именного маршрута:

	$url = route('profile');

#### Генерация URL именного маршрута с передачей параметра маски:

	$url = route('profile', array($username));

#### Генерация URL действия контроллера:

	$url = action('user@profile');

#### Генерация URL действия контроллера с передачей параметра маски:

	$url = action('user@profile', array($username));
