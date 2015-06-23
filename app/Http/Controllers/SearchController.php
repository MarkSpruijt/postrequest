<?php namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller {

    public function __construct()
    {
        /* ... */
    }

    public function getIndex(){
        return view('search.findtag');
    }

    public function postIndex(Request $request)
    {
        if($request->input('tag') == NULL)
        {
            return view('search.findtag')->withMessages(['type' => 'error', 'messages' => ["Zoekbalk mag niet leeg zijn."]]);
        }
        $tag = Tag::cleanTags($request->input('tag'));
        /* Tag::cleanTags returns an array & urlencode only accepts strings. */
        $tag = urlencode($tag[0]);
        return redirect('search/tags/' . $tag);
    }

    public function getTags($tag)
    {
        /* Decode tag from url */
        $tag = urldecode($tag);
        if($questions = Tag::where('tag',$tag)->first())
        {
            $questions = $questions->question()->orderBy('updated_at','DESC')->get();
            return view('search.tags', compact('questions', 'tag'));
        }
        return view('search.tags', compact('tag'))->withMessages(['type'=> 'error', 'messages' => ['Er zijn geen vragen gevonden bij deze tag.']]);
    }
}

