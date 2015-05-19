<?php

Route::get('/','QuestionController@getIndex');
Route::get('question/{question_id}', 'QuestionController@getDetails');

Route::get('logout', 'UserController@getLogout');
Route::get('question/{question_id}/{answer_id}/comment', 'CommentController@getCreate');
Route::post('question/{question_id}/{answer_id}/comment', 'CommentController@postCreate');
Route::get('question/{question_id}/{answer_id}/choose', 'QuestionController@chooseAnswer');
Route::get('ask','QuestionController@getCreate');
Route::Post('ask','QuestionController@postCreate');

Route::controllers([
	'account' => 'UserController',
	'answer' => 'AnswerController'
]);
