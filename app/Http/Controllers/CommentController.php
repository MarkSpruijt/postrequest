<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;

class CommentController extends Controller {

	public function __construct()
	{
		$this->middleware('App\Http\Middleware\Authenticate');
	}
	public function getCreate($question_id, $answer_id){
		$answer = Answer::find($answer_id);
		
		if(!$answer->exists)
		{
			return App::abort(404);
		}

		return view('comment/create');
	}

	public function postCreate(Request $request, $question_id, $answer_id)
	{
		$data = $request ->only('content');
		$data['user_id'] = $request->user()->id;
		$data['answer_id'] = $answer_id;
		$comment = new Comment;
		$comment->fill($data)->save(); 

		return redirect('/');
	}
}