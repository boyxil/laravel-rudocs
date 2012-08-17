# Пагинация

## Содержание

- [Основы](#the-basics)
- [Использование Query Builder](#using-the-query-builder)
- [Вставки в ссылки пагинации](#appending-to-pagination-links)
- [Создание пагинации вручную](#creating-paginators-manually)
- [Применение стилей к пагинации](#pagination-styling)

<a name="the-basics"></a>
## Основы

Пагинатор Laravel был разарботан для упорядочивания постраничного вывода контента.

<a name="using-the-query-builder"></a>
## Использование Query Builder

Давайте рассмотрим полный пример использования пагинации с использованием [Fluent Query Builder](/docs/database/fluent):

#### Получение разбитого на страницы запроса из базы данных:

	$orders = DB::table('orders')->paginate($per_page);

#### Отображение результата в представлении:

	<?php foreach ($orders->results as $order): ?>
		<?php echo $order->id; ?>
	<?php endforeach; ?>

#### Генерация постраничных ссылок:

	<?php echo $orders->links(); ?>

Метод links() создает хорошо организованный список постраничной навигации, примерно такой:

	Previous 1 2 ... 24 25 26 27 28 29 30 ... 78 79 Next

Пагинатор автоматически определяет, на какой странице вы находитесь и обновляет результаты и ссылки.

Кроме того, можно создавать ссылки "next" и "previous":

#### Генерация отдельных ссылок "previous" и "next":

	<?php echo $orders->previous().' '.$orders->next(); ?>

*Рекомендуем прочитать:*

- *[Fluent Query Builder](/docs/database/fluent)*

<a name="appending-to-pagination-links"></a>
## Вставки в ссылки пагинации

вам может панодобиться вставить дополнительные ссылки в пагинацию, такие как сортировка и другие.

#### Вставка строки запроса в ссылки пагинации:

	<?php echo $orders->appends(array('sort' => 'votes'))->links();

Эта инструкция сгенерирует URL в виде:

	http://example.com/something?page=2&sort=votes

<a name="creating-paginators-manually"></a>
## Создание пагинации вручную

Если вам нужно создать пагинацию вручную, без участия "query builder", вы можете поступить так:

#### Создание экземпляра **Paginator** пагинации вручную:

	$orders = Paginator::make($orders, $total, $per_page);

<a name="pagination-styling"></a>
## Применение стилей к пагинации

Все элементы пагинации, конечно же, могут использовать стили CSS:

    <div class="pagination">
        <a href="foo" class="previous_page">Previous</a>

        <a href="foo">1</a>
        <a href="foo">2</a>

        <span class="dots">...</span>

        <a href="foo">11</a>
        <a href="foo">12</a>

        <span class="current">13</span>

        <a href="foo">14</a>
        <a href="foo">15</a>

        <span class="dots">...</span>

        <a href="foo">25</a>
        <a href="foo">26</a>

        <a href="foo" class="next_page">Next</a>
    </div>

Можно отключать ненужные ссылки, например:

	<span class="disabled prev_page">Previous</span>
