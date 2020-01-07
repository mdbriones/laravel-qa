<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title',
        'body'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    //accessor
    public function getUrlAttribute() // called in index as $question->url
    {
        return route('questions.show', $this->id);
    }

    //accessor
    public function getCreatedDateAttribute() // called in index as $question->created_date
    {
        return $this->created_at->diffForHumans(); // ex. 1 day ago 
    }
}
