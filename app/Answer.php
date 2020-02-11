<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Answer extends Model
{
    // all the method define in the trait file will be available in this model.
    // trait is created in the app folder.
    use VotableTrait; 

    protected $fillable = [
        'body',
        'user_id'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return Purifier::clean(\Parsedown::instance()->text($this->body));
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function getCreatedDateAttribute() // called in index.blade.php as $question->created_date
    {
        return $this->created_at->diffForHumans(); // diffForHumans() method returns => ex. 1 day ago 
    }

    public function getStatusAttribute() // constructor --> called as $answer->status.... the 'Status' part in the getStatusAttribute is automatically understood by laravel if answer->status is called. 
    {
        return $this->id == $this->question->best_answer_id ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();    
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }
}
