<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Question extends Eloquent{

	protected $fillable = [
		'title','content', 'answer_id', 'user_id'
	];

	public function answers()
	{
		return $this->hasMany('App\Models\Answer');
	}

	/**
	*	Puts the right answer on top.
	*
	* 	@return void
	*/
	public function sortAnswers()
	{
		if($this->answer_id !== NULL)
		{
			foreach($this->answers as $i => $answer)
			{
				if($answer->id === $this->answer_id)
				{
					$tempAnswer = $answer;
					$this->answers->forget($i);
					$this->answers->prepend($tempAnswer);	
					break;
				}
			}
		}


	}

}