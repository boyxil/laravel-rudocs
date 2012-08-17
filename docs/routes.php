<?php

/**
 * Load the Markdown library.
 */
require_once __DIR__.'/libraries/markdown.php';

/**
 *   Define language variable
 */
$GLOBALS['langdoc'] = 'en';

/**
 * Set language function
 */
function set_language()
{
	$l = Input::get('language'); //read language from get query
	if ($l !==NULL)
	{
		$GLOBALS['langdoc'] = $l;	// set language
		Session::put('language', $GLOBALS['langdoc']); //save language in session
	}
	else
	{
		$GLOBALS['langdoc'] = Session::get('language', 'en');
	}
}

/**
 * Get the root path for the documentation Markdown.
 *
 * @return string
 */
function doc_root()
{
	return path('sys').'documentation/'.$GLOBALS['langdoc'].'/';
}

/**
 * Get the parsed Markdown contents of a given page.
 *
 * @param  string  $page
 * @return string
 */
function document($page)
{
	return Markdown(file_get_contents(doc_root().$page.'.md'));
}

/**
 * Determine if a documentation page exists.
 *
 * @param  string  $page
 * @return bool
 */
function document_exists($page)
{
	$GLOBALS['docpath'] = doc_root().$page.'.md';
	return file_exists(doc_root().$page.'.md');
}

/**
 * Attach the sidebar to the documentatoin template.
 */
View::composer('docs::template', function($view)
{
	
	$view->with('sidebar', document('contents'));
});

/**
 * Handle the documentation homepage.
 *
 * This page contains the "introduction" to Laravel.
 */
Route::get('(:bundle)', function()
{
	set_language();
	return View::make('docs::page')->with('content', document('home'));
});

/**
 * Handle documentation routes for sections and pages.
 *
 * @param  string  $section
 * @param  string  $page
 * @return mixed
 */
Route::get('(:bundle)/(:any)/(:any?)', function($section, $page = null)
{
	$file = rtrim(implode('/', func_get_args()), '/');
	set_language();
	// If no page was specified, but a "home" page exists for the section,
	// we'll set the file to the home page so that the proper page is
	// display back out to the client for the requested doc page.
	if (is_null($page) and document_exists($file.'/home'))
	{
		$file .= '/home';
	}

	if (document_exists($file))
	{
		return View::make('docs::page')->with('content', document($file));
	}
	else
	{
		return Response::error('404');
	}
});
