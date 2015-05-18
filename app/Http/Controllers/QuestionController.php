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
}