<?php
/**
 * Created by Mark.
 * Date: 6/12/2015
 * Time: 5:17 PM
 */

namespace App\Logics;

use Auth;
use Validator;
use App\Models\Question;

class QuestionLogic
{

    static function createQuestion($request)
    {
        $data = $request->only('title', 'content');
        $data['user_id'] = Auth::user()->id;
        $v = Validator::make($data, ['title' => 'required', 'content' => 'required|min:120']);
        $v->setAttributeNames(['title' => 'Titel', 'content' => 'Inhoud']);
        if ($v->fails()) {
            $request->flash();
            return redirect()->action('QuestionController@getCreate')->withMessages(['type' => 'error', 'messages' => $v->messages()->all()]);
        }
        $question = new Question;
        $question->fill($data)->save();
        return redirect('question/' . $question->id);
    }

    static function editQuestion($request, $id)
    {
        $data = $request->only('title', 'content');
        $v = Validator::make(
            $data,
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
            $question->fill($data)->save();

            return redirect('question/' . $question->id);
        }
    }
}