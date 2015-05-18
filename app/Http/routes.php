<?php

Route::get('/','QuestionController@index');

Route::get('question/{question_id}/{answer_id}/comment', 'CommentController@getCreate');
Route::post('question/{question_id}/{answer_id}/comment', 'CommentController@postCreate');
Route::get('question/{question_id}/{answer_id}/choose', 'QuestionController@chooseComment');

Route::controllers([
	'question'	=> 'QuestionController',
	'account' => 'UserController',

	// Deze shizzledizzle moet onderaan blijven staan anders verzuipen de kikkers.
	'/' => 'HomeController'
]);
