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
        return $this->belongsToMany('App\Models\Tag');
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
			foreach ($answer->comments as $comment) {
				$votes = CommentVote::where('comment_id', $comment['id'])->get();
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

                $comment->votes = $totalvotes;
                $commentVote = CommentVote::where('user_id', Auth::User()->id)->where('comment_id', $comment['id'])->first();
                if($commentVote || Auth::user()->id === $comment->user_id){
                    $comment->disablevote = true;
                }
                if($commentVote){
                    $comment->userVote = $commentVote->vote;
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

            $vote = AnswerVote::where('user_id', Auth::User()->id)->where('answer_id', $answer['id'])->first();

            $answerVote = AnswerVote::where('user_id', Auth::User()->id)->where('answer_id', $answer['id'])->first();
            if($answerVote || Auth::user()->id === $answer->user_id){
                $answer->disablevote = true;
            }
            if($answerVote){
                $answer->disablevote = true;
                $answer->userVote = $answerVote->vote;
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