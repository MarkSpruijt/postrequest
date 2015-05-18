<?php

Route::get('question/{question_id}/{answer_id}/comment', 'CommentController@getCreate');
Route::post('question/{question_id}/{answer_id}/comment', 'CommentController@postCreate');

Route::controllers([
	'/question'	=> 'QuestionController',
	'account' => 'UserController',

	//This Route needs to stay at the BOTTOM!!!!!!! Or everything will DIE!!!
	'/' => 'HomeController' 	
]);
