<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Faker\Core\Uuid;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\AttemptedUser;

class quizController extends Controller
{
    // Creates a new quiz
    public function quizform(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|min:4|max:30',
            'descp' => 'required|min:10|max:100',
            'time_limit' => 'required|integer|min:0'
        ]);
        if ($validator->fails()) {
            // return redirect('/login')->withErrors($validator)
            // ->withInput();
        }

        $timeLimit = (int) $req->time_limit;

        $uuid = rand(0, 999999);
        while (DB::table('quizzes')->where('id', $uuid)->exists()) {
            // If not unique, generate a new random number
            $uuid = rand(0, 100000);
        }
        session(['quizID' => $uuid]);

        $quizdata = [[
            'time_limit' => $req->time_limit,
            'title' => $req->name,
            'description' => $req->descp,
            'id' => $uuid,
        ]];
        $quiz = Quiz::insert($quizdata);
        return redirect('/createquiz');
    }

    // Adds a new question to a quiz
    public function createques(Request $req)
    {
        //    return $req->correct_option==4;
        // $quiz = Quiz::with('questions.options', 'attemptedusers')->find();
        $qid = null;

        // Create a new question
        $newquestion = Question::create([
            'ques' => $req->ques,
            'quiz_id' => session('quizID'),
        ]);

        // Get the ID of the newly created question
        $qid = $newquestion->id;

        // Create multiple options for the question
        $newoptionsData = [
            [
                'opt' => $req->opt1,
                'question_id' => $qid,
                'result' => ($req->correct_option == 1),

            ],
            [
                'opt' => $req->opt2,
                'question_id' => $qid,
                'result' => ($req->correct_option == 2),

            ],
            [
                'opt' => $req->opt3,
                'question_id' => $qid,
                'result' => ($req->correct_option == 3),

            ],
            [
                'opt' => $req->opt4,
                'question_id' => $qid,
                'result' => ($req->correct_option == 4),
            ],
        ];

        // Use the Option model's create method within an array of data
        $newoptions = Option::insert($newoptionsData);

        return redirect('/createquiz');
    }

    // Retrieves all quizzes for display
    public function allquiz()
    {
        $user = User::find(session('loginID'));
        $quizzes = Quiz::with('questions.options')->get();
        return view('allquizzes', ['user' => $user, 'quizzes' => $quizzes]);
    }
    // Displays a specific quiz
    public function squiz($qid)
    {
        $user = User::find(session('loginID'));
        $quiz = Quiz::with('questions.options')->where('id', $qid)->first();
        if ($user) {
            return view('singlequiz', ['user' => $user, 'quiz' => $quiz]);
        } else {
            return 'User not found';
        }
    }
    // Processes a submitted quiz and calculates the score
    public function quizsubmit(Request $req, $id)
    {
        $userId = session('loginID');
        $quizId = $id;

        // Check if the user has already attempted this quiz
        $attemptedUser = AttemptedUser::where('quiz_id', $quizId)
            ->where('user_id', $userId)
            ->first();

        // if ($attemptedUser) {
        //     return back()->with('error', 'You have already attempted this quiz.');
        // }

        $quiz = Quiz::with('questions.options')->where('id', $id)->first();
        $response = [];
        $score = 0;
        $res = [];

        foreach ($quiz->questions as $question) {
            $selectedAnswer = $req[$question->id] ?? null;
            $res[$question->id] = $selectedAnswer;

            $correctOption = $question->options->where('result', true)->first();

            if ($selectedAnswer && $selectedAnswer === $correctOption->opt) {
                $score++;
                $response[] = "Correct Answer !!!";
            } else {
                $response[] = "Wrong Answer !!!";
            }
        }
        $response['score'] = $score;

        $userId = session('loginID');
        $quizId = $id;

        // Add or update attempted user data
        AttemptedUser::updateOrInsert(
            [
                'quiz_id' => $quizId,
                'user_id' => $userId
            ],
            [
                'bestScore' => DB::raw("GREATEST(COALESCE(bestScore, 0), $score)"),
                'attempts' => DB::raw('COALESCE(attempts, 0) + 1')
            ]
        );
        return redirect()->route('quizresult', ['id' => $id])->with(['response' => $response, 'inpt' => $res]);
    }

    public function aquiz($id)
    {
        $user = User::find(session('loginID'));
        $quiz = Quiz::with('questions.options')->where('id', $id)->first();
        
        // Retrieve the response and input data from the session
        $response = session('response');
        $inpt = session('inpt');
        return view('aquiz', [
            'user' => $user, 
            'quiz' => $quiz,
            'response' => $response,
            'inpt' => $inpt
        ]);
    }
}
