<?php

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customAuthController;
use App\Http\Controllers\quizController;
use Illuminate\Contracts\Session\Session;

function finduser()
{
    return User::find(session('loginID'));
};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Routes that are accessible only when the user is not logged in 
Route::group(['middleware' => 'loginusercheck'], function () {
    // Route to display the login page
    Route::view('/login', 'login');
    // Route to display the registration page
    Route::view('/registration', 'registration');
});

// Authentication routes
// Route to handle login form submission
Route::post('/login', [customAuthController::class, 'loginuser'])->name('login');
// Route to handle registration form submission
Route::post('/registration', [customAuthController::class, 'registeruser'])->name('registration');



// Home page route
// Route to display the home page
Route::view('/', 'index');

// Routes that require authentication
Route::middleware(['authenticationcheck'])->group(function () {
    // Route to display the home page for authenticated users
    Route::get('/dashboard', [customAuthController::class, 'dashboard'])->name('dashboard');
    // Route to handle user logout
    Route::get('/logout', [customAuthController::class, 'logoutuser'])->name('logout');

    // Route to display quiz form with 'isteachercheck' middleware
    Route::get('/quizform', function () {
        $user = finduser();
        // If user is found, display the quiz form view
        return view('quizform', ['user' => $user]);
    })->middleware('isteachercheck');

    // Route to display quiz creation page with 'isteachercheck' middleware
    Route::get('/createquiz', function () {
        $qid = Session('quizID');
        $quiz = Quiz::with('questions.options')->find($qid);
        $user = finduser();
        // If user is found, display the quiz creation view with user and quiz data
        return view('createquiz', ['user' => $user, 'quiz' => $quiz]);
    })->middleware('isteachercheck');

    // Route to display all quizzes
    Route::get('/allquizzes', [quizController::class, 'allquiz'])->name('allquiz');

    // Route to display a single quiz
    Route::get('/singlequiz/{id}', [quizController::class, 'squiz'])->name('squiz');
    Route::get('/quizresult/{id}', [quizController::class, 'aquiz'])->name('quizresult');
});

// Quiz creation routes
// Route to handle quiz form submission
Route::post('/quizform', [quizController::class, 'quizform'])->name('quizform');

// Route to handle quiz creation
Route::post('/createquiz', [quizController::class, 'createques'])->name('createques');

// Route to submit a quiz
Route::post('/quiz/submit/{id}', [quizController::class, 'quizsubmit'])->name('quizsubmit')->middleware('isstudentcheck');


// Debug route to display quiz data
// Route to display all quizzes with their questions, options, and attempted users
//Route::get('/quiz', function () {
//  $id = 1;
//$quiz = Quiz::with('questions.options', 'attemptedusers')->get();
// return $quiz;
//});



//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

//Route::view('/dashboard', 'dashboard');
