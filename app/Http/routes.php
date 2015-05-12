<?php

Route::controllers([
	'/question'	=> 'QuestionController',
	'account' => 'UserController',

	//This Route needs to stay at the BOTTOM!!!!!!! Or everything will DIE!!!
	'/' => 'HomeController' 	
]);
