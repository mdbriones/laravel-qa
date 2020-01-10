<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer) // will be called if there were no method indicated in the web.php route for acceptanswercontroller | this is called single action controller
    {
        $this->authorize('accept', $answer);
        
        $answer->question->acceptBestAnswer($answer);

        return back();
    }
}
