# Тестирование модулей

## Содержание

- [Основы](#the-basics)
- [Создание тест класса](#creating-test-classes)
- [Запуск тестов](#running-tests)
- [Вызов контроллеров из теста](#calling-controllers-from-tests)

<a name="the-basics"></a>
## Основы

Модульное тестирование позволяет проверить код и убедиться, что он работает правильно. Многие утверждают, что вы должны еще написать тесты, прежде чем написать свой код! Laravel открывает прекрасную интеграцию с популярными библиотеками тестирования [PHPUnit] (http://www.phpunit.de/manual/current/en/), что позволяет легко писать тесты. На самом деле, Laravel включает в себя сотни модульных тестов!

<a name="creating-test-classes"></a>
## Создание класса теста

Все тесты приложения размещаются в  **application/tests**. В этом каталоге вы найдете основной **example.test.php** файлы. Откройте его и посмотрите на класс, он включает в себя:

	<?php

	class TestExample extends PHPUnit_Framework_TestCase {

		/**
		 * Test that a given condition is met.
		 *
		 * @return void
		 */
		public function testSomethingIsTrue()
		{
			$this->assertTrue(true);
		}

	}

Обратите особое внимание **.test.php** суффикс. Это говорит Laravel, что он должна включить этот класс в качестве теста при выполнении теста. Любые файлы в каталоге, не имеющие этот суффикс, рассматриваться не будут.

Если вы пишете тесты для бандла, поместите их в каталог тестов **tests** бандла. Laravel позаботится об остальном!

Для получения более подробной информации смотрите [PHPUnit documentation](http://www.phpunit.de/manual/current/en/).

<a name="running-tests"></a>
## Запуск тестов

Для запуска тестов используется консольная утилита Artisan. 

#### Запуск теста посредством Artisan CLI:

	php artisan test

#### Запуск теста для бандла:

	php artisan test bundle-name

<a name="#calling-controllers-from-tests"></a>
## Вызов контроллеров в тестах

Некоторые примеры вызовов контроллеров из тестов:

#### Вызов контроллера из теста:

	$response = Controller::call('home@index', $parameters);

#### Создание екземпляра контроллера из теста:

	$controller = Controller::resolve('application', 'home@index');

> **Примечание:** Фильтры контроллера все равно будет работать при использовании Controller::call метода.
