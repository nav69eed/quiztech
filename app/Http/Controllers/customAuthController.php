<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attempteduser;
use App\Models\Quiz;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class customAuthController extends Controller
{
    public function registeruser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|max:16',
            'role' => 'required|in:student,teacher'
        ]);
        if ($validator->fails()) {
            return redirect('/registration')->withErrors($validator)
                ->withInput();
        }

        $picUrl = $req->input('pic') ?? 'https://cdn-icons-png.flaticon.com/512/6386/6386976.png';
        $userData = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'pic' => $picUrl,
            'role' => $req->role, // Ensure 'role' is included here
        ];

        $user = User::create($userData);

        if ($user) {
            $req->session()->put('loginID', $user->id);
            $req->session()->put('role', $user->role); // Add role to session
            $intendedUrl = session('intended_url', '/dashboard');
            session()->forget('intended_url'); // Clear the intended URL from the session
            return redirect($intendedUrl);
        } else {
            return redirect('/registration')->with('fail', 'An Error Occurred');
        }
    }

    public function loginuser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator)
                ->withInput();
        }
        $user = User::where('email', '=', $req->email)->first();
        if ($user) {

            if (Hash::check($req->password, $user->password)) {
                $req->session()->put('loginID', $user->id);
                $req->session()->put('role', $user->role); // Add role to session
                $intendedUrl = session('intended_url', '/dashboard');
                session()->forget('intended_url'); // Clear the intended URL from the session
                return redirect($intendedUrl);
            } else {
                return back()->with('fail', 'Password Incorrect. Try again !!');
            }
        } else {
            return back()->with('fail', 'Email not Registered !!');
        }
    }

    public function logoutuser(Request $req)
    {
        $req->session()->pull('loginID');
        return redirect('/login')->with('success', 'Logged Out Successfully');
    }
    public function dashboard()
    {
        $user = User::find(session('loginID'));
        // Get the number of quizzes
        $quizCount = Quiz::count(); // Total quizzes
        $studentCount = User::where('role', 'student')->count();
        $recentQuizzes = Quiz::latest()->take(4)->get();

        // Fetch quizzes whose due datetime is over
        $overdueQuizzes = Quiz::where('due_datetime', '<', now())->get(); // Fetch overdue quizzes
        $overdueQuizCount = $overdueQuizzes->count(); // Count of overdue quizzes

        // Fetch quizzes whose due datetime is very near (e.g., within the next 24 hours)
        $nearDueQuizzes = Quiz::select('quizzes.*', DB::raw('DATEDIFF(due_datetime, NOW()) as remaining_days')) // Calculate remaining days
            ->where('due_datetime', '>', now())
            ->where('due_datetime', '<=', now()->addDay(20)) // Adjust the time frame as needed
            ->orderBy('due_datetime', 'asc') // Order by due date
            ->take(4) // Limit to 4 quizzes
            ->get(); // Fetch quizzes nearing their due date

        // Update this line to count quizzes attempted by the user
        $attemptedQuiz = DB::table('attemptedusers')
            ->join('quizzes', 'attemptedusers.quiz_id', '=', 'quizzes.id') // Join with quizzes table
            ->where('attemptedusers.user_id', session('loginID'))
            ->select('attemptedusers.*', 'quizzes.title as quiz_name') // Select attempted quiz data and quiz title
            ->orderBy('attemptedusers.updated_at', 'desc') // Order by percentage scored in descending order
            ->take(4) // Fetch top 2 attempted quizzes
            ->get(); // Fetch quizzes attempted by the user
        $attemptedQuizCount = $attemptedQuiz->count();
        $topUsers = DB::table('attemptedusers')
            ->join('users', 'attemptedusers.user_id', '=', 'users.id') // Join with users table
            ->select('attemptedusers.user_id', 'users.name as user_name', DB::raw('AVG(attemptedusers.percentage_scored) as avg_score')) // Select user name from users table
            ->groupBy('attemptedusers.user_id', 'users.name') // Group by user_id and user name
            ->orderBy('avg_score', 'desc')
            ->take(4)
            ->get();

        // Calculate average percentage of obtained marks in all quizzes by the student
        $averageScore = round(DB::table('attemptedusers')
            ->where('user_id', session('loginID'))
            ->avg('percentage_scored'), 2); // Calculate average percentage scored and round to 2 decimal places
        if ($user) {
            if (session('role') == 'teacher') {
                return view('dashboard', [
                    'user' => $user,
                    'quizCount' => $quizCount,
                    'studentCount' => $studentCount,
                    'recentQuizzes' => $recentQuizzes,
                    'topusers' => $topUsers,
                    'overdueQuizCount' => $overdueQuizCount // Send count of overdue quizzes
                ]);
            } elseif (session('role') == 'student') {
                return view('studentdashboard', [
                    'user' => $user,
                    'attemptedQuiz' => $attemptedQuiz,
                    'attemptedQuizCount' => $attemptedQuizCount,
                    'averageScore' => $averageScore, // Send average score to the view
                    'nearDueQuizzes' => $nearDueQuizzes // Send quizzes nearing their due date
                ]);
            } else {
                return redirect('/logout')->with('error', 'Invalid role');
            }
        } else {
            return redirect('/logout')->with('error', 'User not found');
        }
    }

    //delete specific student
    public function deletestudent($id)
    {

        $success = DB::table('users')->where('id', '=', $id)->delete();
        $user = User::find(session('loginID'));
        // Fetch students and their average scores
        $students = User::where('role', 'student')->get()->map(function ($student) {
            $averageScore = AttemptedUser::where('user_id', $student->id)
                ->avg('percentage_scored');

            // Add count of quizzes attempted by the student
            $attemptsCount = AttemptedUser::where('user_id', $student->id)
                ->count();
            return [
                'name' => $student->name,
                'user_id' => $student->id,
                'email' => $student->email,
                'average_score' => $averageScore,
                'attempts_count' => $attemptsCount, // Added attempts count
            ];
        });

        // return $students;
        return view('studentlist', ['user' => $user, 'students' => $students]);
    }
}
