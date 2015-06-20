<?php namespace App\Http\Controllers;

use App\Models\Tag;

class SearchController extends Controller {

    public function __construct()
    {
        /* ... */
    }

    public function getTags($tag)
    {
        /* Decode tag from url */
        $tag = urldecode($tag);
        if($questions = Tag::where('tag',$tag)->first())
        {
            $questions = $questions->question;
            return view('search.tags', compact('questions', 'tag'));
        }
        return view('search.tags', compact('tag'))->withMessages(['type'=> 'error', 'messages' => ['Er zijn geen vragen gevonden bij deze tag.']]);
    }
}

