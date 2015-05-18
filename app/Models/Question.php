<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Question extends Eloquent{

		protected $fillable = [
		'title','content', 'answer_id', 'user_id'
	];
}