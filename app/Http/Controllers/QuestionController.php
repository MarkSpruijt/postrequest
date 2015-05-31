<?php namespace App\Http\Controllers;

use App;
use Auth;
use Mail;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Question;
use Validator;

class QuestionController extends Controller {

	public function __construct()
	{
		$this->middleware('App\Http\Middleware\Authenticate');
	}

	public function getIndex()
	{
		$questions = Question::orderBy('created_at', 'ASC')->get();
		return view('home', compact('questions'));

	}

	public function getDetails($id)
	{
		$question = Question::find($id);
		$question->sortAnswers();

		return view('question.details', compact('question'));
	}

	public function getCreate(){
		return view('question/create');
	}

	public function postCreate(Request $request)
	{
		$data = $request ->only('title','content');
		$data['user_id'] = Auth::user()->id;
		$question = new Question;
		$question->fill($data)->save(); 

		return redirect('/');
	}

	public function getEdit($id)
	{
		$question = Question::find($id);
		if($question && $question->user_id == Auth::user()->id)
			return view('question.edit')->withQuestion($question);

		return App::abort('403');
	}

	public function postEdit(Request $request, $id)
	{
		$createquestion = $request->only('title', 'content');

		$v = Validator::make(
			$createquestion,
			[
				'title' => 'required', 
				'content' => 'required'
			]
		);

		$v->setAttributeNames(['title' => 'Titel', 'content' => 'Inhoud']);

		if($v->fails())
		{
			$request->flash();
			return redirect()->action('QuestionController@getEdit', $id)->withErrors($v->messages());
		}
		
		$question = Question::find($id);
		if($question && $question->user_id == Auth::user()->id)
		{
			$data = $request->only('title', 'content');

			$question->fill($data);

			$question->save();

			return redirect('question/' . $question->id);
		}
	}

	public function chooseAnswer($question_id, $answer_id)
	{
		$question  = Question::find($question_id);
		
		// Is het de eigenaar van de question en bestaat het antwoord uberhaupt wel?
		if(Auth::user()->id ==  $question->user_id && Answer::find($answer_id)->exists)
		{
			$question->answer_id = ($question->answer_id == $answer_id) ? NULL : $answer_id;
			$question->save();
		}


		// Dit aanpassen naar de locatie van de detailpagina.
		return redirect('/question/' . $question_id);
	}
}