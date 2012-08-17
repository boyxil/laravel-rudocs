# Задачи

## Содержание

- [Основы](#the-basics)
- [Создание и запуск задач](#creating-tasks)
- [Задачи бандлов](#bundle-tasks)
- [CLI опции](#cli-options)

<a name="the-basics"></a>
## Основы

Утилита командной строки Laravel называется Artisan. Artisan используется для таких задач как имграции, задачи по расписанию, юнит-тесты, или созданные пользователем задачи.

<a name="creating-tasks"></a>
## Создание и запуск задач

Для создания задачи создайте новы класс в директории **application/tasks**. Имя класса должно иметь суффикс "_Task", и он должен иметь хотя бы "run" метод. Пример:

#### Creating a task class:

	class Notify_Task {

		public function run($arguments)
		{
			// Do awesome notifying...
		}

	}

Теперь вы можете вызвать метод "run" вашей задачи в командной строке. Вы можете передать задаче параметры:

#### Вызов задачи в командной строке:

	php artisan notify

#### Вызов задачи с передачей аргументов:

	php artisan notify taylor

Помните, вы можете создавать конкретные методы для своей задачи, поэтому давайте добавим метод "urgent" задачи "Notify":

#### Добавление метода в задачу:

	class Notify_Task {

		public function run($arguments)
		{
			// Do awesome notifying...
		}

		public function urgent($arguments)
		{
			// This is urgent!
		}

	}

Теперь мы можем использовать наш метод "urgent":

#### Вызов метода в задаче:

	php artisan notify:urgent

<a name="bundle-tasks"></a>
## Задачи бандлов

Для создания задачи для бандла установите префикс имени класса задачи в виде имени бандла. Так, если бандл называется "admin", задача будет выглядеть, например, так:

#### Создание класса задачи, принадлежащей бандлу:

	class Admin_Generate_Task {

		public function run($arguments)
		{
			// Generate the admin!
		}

	}

Для запуска задачи используйте знакомый вам синтаксис двойного двоеточия для индикации бандла:

#### Запуск задачи, принадлежащей бандлу:

	php artisan admin::generate

#### Запуск внутреннего метода задачи бандла:

	php artisan admin::generate:list

<a name="cli-options"></a>
## CLI опции

#### Установка окружения Laravel:

	php artisan foo --env=local

#### Установка соединения с базой данных по умолчанию:

	php artisan foo --database=sqlite
