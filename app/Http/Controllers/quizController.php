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
    public function createquiz(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'quizName' => 'required|min:4|max:30',
            'quizDescription' => 'required|min:10|max:100',
            'quizTimelimit' => 'required|integer|min:0',
            'quizSubject' => 'required'
        ]);
        // if ($validator->fails()) {
        //     return redirect('/createquiz')->withErrors($validator)
        //         ->withInput();
        // }
        $timeLimit = $req->quizTimeLimit;
        $uuid = rand(0, 999999);
        while (DB::table('quizzes')->where('id', $uuid)->exists()) {
            // If not unique, generate a new random number
            $uuid = rand(0, 100000);
        }
        session(['quizID' => $uuid]);

        $quizdata = [[
            'time_limit' => $timeLimit,
            'title' => $req->quizName,
            'description' => $req->quizDescription,
            'subject' => $req->quizSubject,
            'id' => $uuid,
            'created_at' => now(), // Add created_at
            'updated_at' => now(), // Add updated_at
        ]];
        $quiz = Quiz::insert($quizdata);
        if ($quiz) {
            session(['quizID' => $uuid]);
        }
        return redirect('/createquestion');
    }

    public function createquestion(Request $req)
    {
        $qid = null;
        // Create a new question
        $newquestion = Question::create([
            'ques' => $req->ques,
            'quiz_id' => session('quizID'),
        ]);
        // Get the ID of the newly created question
        $qid = $newquestion->id;
        $newoptionsData = [
            [
                'opt' => $req->opt1,
                'question_id' => $qid,
                'result' => ($req->correct_option == 1),
                'created_at' => now(), // Add created_at
                'updated_at' => now(), // Add updated_at

            ],
            [
                'opt' => $req->opt2,
                'question_id' => $qid,
                'result' => $req->correct_option == 2,
                'created_at' => now(), // Add created_at
                'updated_at' => now(), // Add updated_at

            ],
            [
                'opt' => $req->opt3,
                'question_id' => $qid,
                'result' => ($req->correct_option == 3),
                'created_at' => now(), // Add created_at
                'updated_at' => now(), // Add updated_at

            ],
            [
                'opt' => $req->opt4,
                'question_id' => $qid,
                'result' => ($req->correct_option == 4),
                'created_at' => now(), // Add created_at
                'updated_at' => now(), // Add updated_at
            ],
        ];

        // Use the Option model's create method within an array of data
        $newoptions = Option::insert($newoptionsData);

        return redirect('/createquestion');
    }

    public function displayquestionform()
    {
        if (!(session()->has('quizID'))) {
            return redirect('/createquiz');
        } else {
            $user = User::find(session('loginID'));
            $quizID = session('quizID');
            $quiz = Question::where('quiz_id', $quizID)->get();
            return view('createquestion', ['quiz' => $quiz, 'user' => $user]);
        }
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

        $totalQuestions = $quiz->questions->count(); // Count total questions
        $percentageScored = ($totalQuestions > 0) ? ($score / $totalQuestions) * 100 : 0; // Calculate percentage

        // Add or update attempted user data
        AttemptedUser::updateOrInsert(
            [
                'quiz_id' => $quizId,
                'user_id' => $userId
            ],
            [
                'bestScore' => DB::raw("GREATEST(COALESCE(bestScore, 0), $score)"),
                'attempts' => DB::raw('COALESCE(attempts, 0) + 1'),
                'percentage_scored' => $percentageScored // Store percentage scored
            ]
        );
        return redirect()->route('quizresult', ['id' => $id])->with(['response' => $response, 'inpt' => $res]);
    }

    public function quizresult($id)
    {
        $user = User::find(session('loginID'));
        $quiz = Quiz::with('questions.options')->where('id', $id)->first();

        // Retrieve the response and input data from the session
        $response = session('response');
        $inpt = session('inpt');
        return view('quizresult', [
            'user' => $user,
            'quiz' => $quiz,
            'response' => $response,
            'inpt' => $inpt
        ]);
    }
    public function createquiz2()
    {
        $user = User::find(session('loginID'));
        return view('createquiz', ['user' => $user]);
    }
}
