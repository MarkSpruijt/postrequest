<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller {

	public function index()
	{
		$questions = Question::orderBy('created_at', 'DESC')->get();

	return view('home', compact('questions'));
	}

	public function __construct()
	{
		$this->middleware('App\Http\Middleware\Authenticate');
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

	public function chooseAnswer($question_id, $answer_id)
	{
		$question  = Question::find($question_id);
		
		// Is het de eigenaar van de question en bestaat het antwoord uberhaupt wel?
		if(Auth::user()->id ==  $question->user_id && Answer::find($answer_id)->exists)
		{
			$question->answer_id = $answer_id;
			$question->save();
		}

		// Dit aanpassen naar de locatie van de detailpagina.
		return redirect('/');
	}
}