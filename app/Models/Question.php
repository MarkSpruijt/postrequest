<?php namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Models\AnswerVote;
use App\Models\CommentVote;

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

    public function tags()
    {
        return $this->hasMany('App\Models\Tags');
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
			foreach ($answer->comments as $commentVote) {
				$votes = CommentVote::where('comment_id', $commentVote['id'])->get();
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
			$commentVote->votes = $totalvotes;
			if(CommentVote::where('user_id', Auth::User()->id)->where('comment_id', $commentVote['id'])->first() || Auth::user()->id === $commentVote->user_id){
				$commentVote->disablevote = true;
			}
			}	
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
			if(AnswerVote::where('user_id', Auth::User()->id)->where('answer_id', $answer['id'])->first() || Auth::user()->id === $answer->user_id){
				$answer->disablevote = true;
			}
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