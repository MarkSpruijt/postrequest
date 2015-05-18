<?php

Route::get('/','QuestionController@getIndex');
Route::get('question/{question_id}', 'QuestionController@getDetails');

Route::get('question/{question_id}/{answer_id}/comment', 'CommentController@getCreate');
Route::post('question/{question_id}/{answer_id}/comment', 'CommentController@postCreate');
Route::get('question/{question_id}/{answer_id}/choose', 'QuestionController@chooseAnswer');

Route::controllers([
	'question'	=> 'QuestionController',
	'account' => 'UserController',
	'answer' => 'AnswerController'
]);
