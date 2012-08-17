# Шаблоны

## Содержание

- [Основы](#the-basics)
- [Секции](#sections)
- [Интерпретатор шаблонов Blade ](#blade-template-engine)
- [Шаблоны Blade](#blade-layouts)

<a name="the-basics"></a>
## Основы

Ваше приложение, скорее всего, имеет общее оформление для большинства страниц. Ручное оформление этого шаблона для каждого действия наверняка утомительно. Определение шаблона для приложения сделают, конечно же, разработку более приятной. Начнем:

#### Указание свойства "layout" в контроллере:

	class Base_Controller extends Controller {

		public $layout = 'layouts.common';

	}

#### Доступ к шаблону из действий контроллера:

	public function action_profile()
	{
		$this->layout->nest('content', 'user.profile');
	}

> **Примечание:** Когда используется шаблон, действие не должно больше ничего возвращать.

<a name="sections"></a>
## Секции

Секции представлений предоставляют простой инструмент вставки контента в шаблон из вложенных представлений.
Например, вам нужно вставить JavaScript в ваш шаблон из вложенного представления в заголовок шаблона. Создаем секцию:

#### Создание секции в представлении:

	<?php Section::start('scripts'); ?>
		<script src="jquery.js"></script>
	<?php Section::stop(); ?>

#### Вставка контента секции:

	<head>
		<?php echo Section::yield('scripts'); ?>
	</head>

#### Использование сокращений Blade при работе с секциями:

	@section('scripts')
		<script src="jquery.js"></script>
	@endsection

	<head>
		@yield('scripts')
	</head>

<a name="blade-template-engine"></a>
## Интерпретатор шаболнов Blade

Blade позволяет изящно писать ваши шаблоны. Для создания blade шаблона, файл представления должен иметь расширение ".blade.php". Blade позволяет создавать красивый, ненавязчивый синтаксис PHP структур с отображением данных. Например:

#### Blade отображение переменной:

	Hello, {{$name}}.
	
#### Blade вывод результата функции:

	{{ Asset::styles() }}

#### Вставка представления:

	<h1>Profile</hi>

	@include('user.profile')

> **Примечание:** При использовании **@include** выражения Blade, представление автоматически наследует все данные из текущего представления.

#### Создание циклов при помощи Blade:

	<h1>Comments</h1>

	@foreach ($comments as $comment)
		The comment body is {{$comment->body}}.
	@endforeach

#### Blade другие управляющие структуры:

	@if (count($comments) > 0)
		I have comments!
	@else
		I have no comments!
	@endif

	@for ($i =0; $i < count($comments) - 1; $i++)
		The comment body is {{$comments[$i]}}
	@endfor

	@while ($something)
		I am still looping!
	@endwhile

#### Структура "for-else":

	@forelse ($posts as $post)
		{{ $post->body }}
	@empty
		There are not posts in the array!
	@endforelse

<a name="blade-unless"></a>
#### Структура "unless":

	@unless(Auth::check())
		{{ HTML::link_to_route('login', 'Login'); }}
	@endunless

	// Equivalent...

	<?php if ( ! Auth::check()): ?>
		...
	<?php endif; ?>

<a name="blade-comments"></a>
#### Комментарии в Blade :
	
	@if ($check)
		{{-- This is a comment --}}
		...
	@endif

> **Примечание:** Комментарии Blade, в отличие от HTML комментариев, не отображаются в исходном коде страницы.

<a name="blade-layouts"></a>
## Blade шаблоны

Blade не только делает код представлений элегантным, но еще и дает прекрасный метод использования шаблонов в вашем представлении. Например, пусть ваше приложение использует представление "master" для обеспечения общего вида и поведения приложения. Это может выглядеть так:

	<html>
		<ul class="navigation">
			@section('navigation')
				<li>Nav Item 1</li>
				<li>Nav Item 2</li>
			@yield_section
		</ul>

		<div class="content">
			@yield('content')
		</div>
	</html>

Заметьте, произведена вставка секции "content". Нам нужно заполнить эту секцию некоторым текстом так, чтобы другое представление использовало этот макет:

	@layout('master')

	@section('content')
		Welcome to the profile page!
	@endsection

Отлично! Теперь мы просто возвращаем 'profile' представление из маршрута:

	return View::make('profile');

Представление profile автоматически использует шаблон "master" благодаря **@layout** выражению Blade.

Иногда нужно вставить что-то в секцию, не переписывая ее код. Например, добавить элемент списка. Сделаем это так:

	@layout('master')

	@section('navigation')
		@parent
		<li>Nav Item 3</li>
	@endsection

	@section('content')
		Welcome to the profile page!
	@endsection

Заметили конструкцию Blade **@parent**? Она будет заменена на секцию навигациии 'navigation' из 'master' шаблона, предоставляя гибкий инструмент по управлению контентом в шаблонах и представлениях, делая их расширямыми и наследуемыми.
