<?php namespace App\Http\Controllers;

use App\Models\Tag;

class SearchController extends Controller {

    public function __construct()
    {
        /* ... */
    }

    public function getTags($tag)
    {
        if($questions = Tag::where('tag',$tag)->first()->question)
        {
            return view('search.tags', compact('questions'));
        }
        return view('search.tags')->withMessages(['type'=> 'error', 'messages' => ['Er zijn geen vragen gevonden bij deze tag.']]);
    }
}

