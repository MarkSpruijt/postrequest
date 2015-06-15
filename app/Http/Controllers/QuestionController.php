<?php namespace App\Http\Controllers;

use App;
use Auth;
use App\Models\Answer;
use App\Models\Question;
use App\Logics\QuestionLogic;
use Illuminate\Http\Request;


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
        $question->sortAnswers();

        return view('question.details', compact('question'));
    }

    public function getCreate()
    {
        return view('question/create');
    }

    public function postCreate(Request $request)
    {
        return QuestionLogic::createQuestion($request);
    }

    public function getEdit($id)
    {
        $question = Question::find($id);
        if($question && $question->user_id == Auth::user()->id)
        {
            return view('question.edit')->withQuestion($question);
        }
        return App::abort('403');
    }

    public function postEdit(Request $request, $id)
    {
        return QuestionLogic::editQuestion($request, $id);
    }

    public function chooseAnswer($question_id, $answer_id)
    {
        $question  = Question::find($question_id);
        /* Is het de eigenaar van de question en bestaat het antwoord uberhaupt wel? */
        if(Auth::user()->id ==  $question->user_id && Answer::find($answer_id)->exists)
        {
            $question->answer_id = ($question->answer_id == $answer_id) ? NULL : $answer_id;
            $question->save();
        }
        /* Dit aanpassen naar de locatie van de detailpagina. */
        return redirect('/question/' . $question_id);
    }
}