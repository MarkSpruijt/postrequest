<?php namespace App\Http\Controllers;

use Auth;
use Request;
use App\Models\Answer;
use App\Models\AnswerVote;

class AnswerController extends Controller {

	public function __construct(){
		$this->middleware('App\Http\Middleware\Authenticate');
	}

	public function getIndex($id = 1){
		$answers = Answer::where('question_id', $id)->get();
		
		return view('answer.show')->with('answers', $answers);
	}

	public function getCreate(){
		return view('answer.add');
	}

	public function postCreate($id){
		$content = Request::input('content');
		$user_id = Auth::user()->id;
		Answer::create(['content' => $content,'question_id' => $id, 'user_id' => $user_id]);
		return redirect()->back();
	}

	public function getVote($id){
		$user_id = Auth::user()->id;
		//check if user has voted allready
		if(AnswerVote::where('user_id', $user_id)->where('answer_id', $id)->first()){
			return redirect()->back();
		}
		$vote = new AnswerVote;
		$vote->user_id = $user_id;
		$vote->answer_id = $id;
		$vote->vote = 1;
		$vote->save();
		
		return redirect()->back();
	}

	

}
