<?php

Route::get('/','QuestionController@getIndex');
Route::get('question/{question_id}', 'QuestionController@getDetails');

Route::get('question/edit/{question_id}', 'QuestionController@getEdit');
Route::post('question/edit/{question_id}', 'QuestionController@postEdit');

Route::get('logout', 'UserController@getLogout');
Route::get('question/{question_id}/{answer_id}/comment', 'CommentController@getCreate');
Route::post('question/{question_id}/{answer_id}/comment', 'CommentController@postCreate');
Route::get('question/{question_id}/{answer_id}/choose', 'QuestionController@chooseAnswer');
Route::get('ask','QuestionController@getCreate');
Route::post('ask','QuestionController@postCreate');

//if user rank is 100
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
	Route::controllers([
		'admin' => 'AdminController'
	]);
});

Route::controllers([
	'account' => 'UserController',
	'answer' => 'AnswerController'
]);
