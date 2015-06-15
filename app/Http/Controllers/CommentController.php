<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\CommentVote;

class CommentController extends Controller {

    public function getCreate($question_id, $answer_id) {

        $answer = Answer::find($answer_id);

        if(!$answer->exists)
        {
            return App::abort(404);
        }

        return view('comment/create');
    }

    public function postCreate(Request $request, $question_id, $answer_id) {

        $data = $request ->only('content');
        $data['user_id'] = $request->user()->id;
        $data['answer_id'] = $answer_id;

        $comment = new Comment;
        $comment->fill($data)->save();

        return redirect()->action('QuestionController@getDetails', $question_id);
    }

    public function getEdit($question_id, $answer_id, $comment_id) {

        $comment = Comment::find($comment_id);

        if(!$comment->exists || $comment->user_id !== Auth::user()->id)
        {
            return App::abort(403);
        }

        return view('comment/edit')->withComment($comment);
    }

    public function postEdit(Request $request, $question_id, $answer_id, $comment_id) {

        $data = $request ->only('content');
        $comment = Comment::find($comment_id);

        if(!$comment->exists || $comment->user_id !== Auth::user()->id)
        {
            return App::abort(403);
        }

        $comment->fill($data)->save();

        return redirect()->action('QuestionController@getDetails', $question_id);
    }
    public function getVote($id,$votenumber = 1){
        $user_id = Auth::user()->id;
        //check if user has voted already
        if(CommentVote::where('user_id', $user_id)->where('comment_id', $id)->first()){
            return redirect()->back();
        }
        $vote = new CommentVote;
        $vote->user_id = $user_id;
        $vote->comment_id = $id;
        $vote->vote = $votenumber;
        $vote->save();

        return redirect()->back();
    }

}