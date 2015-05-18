<?php namespace App\Http\Controllers;

use Auth;
use Request;
use App\Models\Answer;

class AnswerController extends Controller {

	public function getIndex($id = 1){
		$answers = Answer::where('question_id', $id)->get();
		
		return view('answer.show')->with('answers', $answers);
	}

	public function getCreate(){
		return view('answer.add');
	}

	public function postCreate($id){
		$content = Request::input('content');
		//$user_id = Auth::User()->user_id;
		$user_id = 2;
		Answer::create(['content' => $content,'question_id' => $id, 'user_id' => $user_id]);
		return redirect()->back();
	}

	

}
