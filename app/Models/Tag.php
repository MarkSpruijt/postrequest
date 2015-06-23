<?php  namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Tag extends Eloquent {

    protected $table = "tags";
    
    protected $fillable = ['tag'];
    
    protected $hidden = [];

    public function Question()
    {
        return $this->belongsToMany('App\Models\Question');
    }

    static function addTags($tags, $question_id)
    {
        $tags = Tag::cleanTags($tags);
        DB::delete("delete from question_tag where question_id='$question_id'");
        foreach($tags as $tag)
        {
            Tag::firstOrCreate(['tag' => $tag])->Question()->attach($question_id);
        }
    }

    static function cleanTags($tags)
    {
        $tags = explode(',', $tags);
        $tags = array_map('trim', $tags);
        $tags = array_map('strtoupper', $tags);
        return $tags;
    }
    
}