<?php
namespace App;

trait VotableTrait
{
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable'); // votable = singular form of the pivot table name = votables
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}