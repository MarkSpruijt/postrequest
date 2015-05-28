<?php namespace App\Http\Controllers;

use Auth;
use App;
use App\Models\Answer;
use App\Models\AnswerVote;
use Illuminate\Http\Request;

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

	public function postCreate(Request $request, $id){
		$data = $request->only('content');
		$user_id = Auth::user()->id;
		Answer::create(['content' => $data['content'],'question_id' => $id, 'user_id' => $user_id]);
		return redirect("question/". $id);
	}

	public function getEdit($id)
	{
		$answer = Answer::find($id);

		if($answer && $answer->user_id == Auth::user()->id)
			return view('answer.edit')->withAnswer($answer);

		return App::abort(403);
	}

	public function postEdit(Request $request, $id)
	{
		$answer = Answer::find($id);
		$data = $request->only('content');

		if($answer && $answer->user_id == Auth::user()->id)
		{
			$answer->content = $data['content'];
			$answer->save();
			return redirect('question/' . $answer->question_id);
		}

		return App::abort(403);

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

		public function getDownVote($id){
		$user_id = Auth::user()->id;
		//check if user has voted allready
		if(AnswerVote::where('user_id', $user_id)->where('answer_id', $id)->first()){
			return redirect()->back();
		}
		$vote = new AnswerVote;
		$vote->user_id = $user_id;
		$vote->answer_id = $id;
		$vote->vote = -1;
		$vote->save();

		return redirect()->back();
	}

	

}
