<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\AnswerVote;

class Question extends Eloquent{

	protected $fillable = [
		'title','content', 'answer_id', 'user_id'
	];

	public function answers()
	{
		return $this->hasMany('App\Models\Answer');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	*	Puts the right answer on top.
	*
	* 	@return void
	*/
	public function sortAnswers()
	{
		foreach($this->answers as $answer)
		{
			//Count votes for answers
			$votes = AnswerVote::where('answer_id', $answer['id'])->get();
			$totalvotes = 0;
			foreach($votes as $vote)
			{
				if($vote['vote']){
					$totalvotes = $totalvotes + 1;
				}
				else{
					$totalvotes = $totalvotes - 1;
				}
			}
			$answer->votes = $totalvotes;
		}
		if($this->answer_id !== NULL)
		{
			//Bring marked answer to the top of the list
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