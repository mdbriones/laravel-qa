<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // user that wants to vote needs to be signed in first
    }

    public function __invoke(Question $question) // __invoke method is automatically called when the controller is used as a single method controller
    {
        $vote = (int) request()->vote;

        auth()->user()->voteQuestion($question, $vote);

        return back();
    }
}
