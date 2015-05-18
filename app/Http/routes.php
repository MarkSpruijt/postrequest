<?php

Route::get('/','QuestionController@index');

Route::controllers([
	'question'	=> 'QuestionController',
	'account' => 'UserController',
	'answer' => 'AnswerController'
]);
