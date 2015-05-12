<?php

Route::controllers([
	'/question'	=> 'QuestionController',

	//This Route needs to stay at the BOTTOM!!!!!!! Or everything will DIE!!!
	'/' => 'HomeController' 
]);
