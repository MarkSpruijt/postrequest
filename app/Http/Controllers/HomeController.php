<?php namespace App\Http\Controllers;

use App\Models\Answer;

class HomeController extends Controller {

	public function getIndex()
	{
		return view('home');
	}

	public function getAnswer($id = 1){
		$answers = Answer::where('question_id', $id)->get();
		
		return view('answer.show')->with('answers', $answers);
	}

}
