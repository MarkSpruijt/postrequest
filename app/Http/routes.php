<?php

Route::controllers([
	'question'	=> 'QuestionController',
	'account' => 'UserController',
	'answer' => 'AnswerController',

	/*
		HomeController need to stay at the bottom. 
		It is a wildcard, all Controller routes under this wildcard will not work!
	*/
	'/' => 'HomeController' 	
]);
