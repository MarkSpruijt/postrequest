<?php namespace App\Http\Controllers;

use Auth;
use App;
use Mail;
use App\Models\Answer;
use App\Models\AnswerVote;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller {

    public function getIndex($id = 1)
    {
        $answers = Answer::where('question_id', $id)->get();
        return view('answer.show')->with('answers', $answers);
    }

    public function getCreate()
    {
        return view('answer.add');
    }

    public function postCreate(Request $request, $id)
    {
        $data = $request->only('content');
        $user_id = Auth::user()->id;
        Answer::create(['content' => $data['content'],'question_id' => $id, 'user_id' => $user_id]);
        $question = Question::find($id);
        $email = $question->user->email;
        $title = $question->title;
        $realname = $question->user->realname;

        Mail::send('emails.answermail', ['title' => $title,'email' => $email,'realname'=> $realname, 'question_id' => $id], function($message) use ($email, $realname, $title)
        {
            $message->to($email, $realname)->subject("[PostRequest] U heeft een antwoord ontvangen op vraag: '$title'");
        });
        return redirect("question/". $id);
    }

    public function getEdit($id)
    {
        $answer = Answer::find($id);
        if($answer && $answer->user_id == Auth::user()->id)
        {
            return view('answer.edit')->withAnswer($answer);
        }
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

    public function getVote($id,$votenumber = 1)
    {
        $user_id = Auth::user()->id;

        $answer = Answer::find($id);

        // A user can't upvote his own answer.
        // Did the user vote already?
        if(!$answer || $user_id === $answer->user_id|| AnswerVote::where('user_id', $user_id)->where('answer_id', $id)->first())
        {
            return redirect()->back();
        }
        $vote = new AnswerVote;
        $vote->user_id = $user_id;
        $vote->answer_id = $id;
        $vote->vote = $votenumber;
        $vote->save();
        return redirect()->back();
    }
}
