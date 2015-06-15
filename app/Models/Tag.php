<?php  namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Tag extends Eloquent {

    protected $table = "tags";
    
    protected $fillable = ['tag'];
    
    protected $hidden = [];

    
}