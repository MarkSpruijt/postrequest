<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class QuestionController extends Controller {

	public function __construct()
	{
		$this->middleware('App\Http\Middleware\Authenticate');
	}

	public function getIndex()
	{
		$questions = Question::orderBy('created_at', 'DESC')->get();
		return view('home', compact('questions'));
	}

	public function getDetails($id)
	{
		$question = Question::find($id);
		$answers = Answer::where('question_id', $id)->get();
		return view('question.details', compact('question', 'answers'));
	}

	public function getCreate(){
		return view('question/create');
	}

	public function postCreate(Request $request)
	{
		$data = $request ->only('title','content');
		$question = new Question;
		$question->fill($data)->save(); 

		return redirect('/');
	}
}