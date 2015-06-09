<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent{

	protected $fillable = [
		'content','user_id', 'answer_id'
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function answer()
	{
		return $this->belongsTo('App\Models\Answer');	
	}

	public function TotalVotes(){
		$votes = $this->Votes;
		dd($votes);
		$totalvotes = 0;
		foreach($votes as $vote){
			if($vote['vote']){
				$totalvotes = $totalvotes + 1;
			}
			else{
				$totalvotes = $totalvotes - 1;
			}
		}
		return $totalvotes;
	}
}