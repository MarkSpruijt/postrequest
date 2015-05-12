<?php namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;

class HomeController extends Controller {



	public function getAnswer($id = 1){
		$answers = Answer::where('question_id', $id)->get();
		
		return view('answer.show')->with('answers', $answers);
	}

}
