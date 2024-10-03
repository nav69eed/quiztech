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

    // Route to display quiz creation page with 'isteachercheck' middleware
    Route::get('/createquiz', [quizController::class,'createquiz2'])->middleware('isteachercheck')->name('CreateQuiz');
    Route::post('/createquiz', [quizController::class, 'createquiz'])->name('createquiz')->middleware('isteachercheck');

    // Route to display question creation page
    Route::get('/createquestion', [quizController::class, 'displayquestionform'])->middleware('isteachercheck')->name('createquestion');
    Route::post('/createquestion', [quizController::class, 'createquestion'])->name('createquestion')->middleware('isteachercheck');

    // Route to display all quizzes
    Route::get('/allquizzes', [quizController::class, 'allquiz'])->name('allquiz');

    // Route to display a single quiz
    Route::get('/singlequiz/{id}', [quizController::class, 'squiz'])->name('squiz');
    Route::get('/quizresult/{id}', [quizController::class, 'quizresult'])->name('quizresult');
});

// Quiz creation routes
// Route to handle quiz form submission


// Route to submit a quiz
Route::post('/quiz/submit/{id}', [quizController::class, 'quizsubmit'])->name('quizsubmit')->middleware('isstudentcheck');
