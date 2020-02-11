<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;
// use Mews\Purifier\Purifier;

class Question extends Model
{
    // all the method define in the trait file will be available in this model.
    // trait is created in the app folder.
    use VotableTrait;

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
    public function getUrlAttribute() // called in index.blade.php as $question->url
    {
        return route('questions.show', $this->slug);
    }

    //accessor
    public function getCreatedDateAttribute() // called in index.blade.php as $question->created_date
    {
        return $this->created_at->diffForHumans(); // diffForHumans() method returns => ex. 1 day ago 
    }

    //accessor
    public function getStatusAttribute()
    {
        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return Purifier::clean($this->bodyHtml());
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    } 

    public function acceptBestAnswer(Answer $answer) // set the value of column best_answer_id in the question table
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    protected function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

    
}
