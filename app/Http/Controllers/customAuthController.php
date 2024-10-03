<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $quizCount = Quiz::count();
        $studentCount = User::where('role', 'student')->count();
        $recentQuizzes = Quiz::latest()->take(4)->get();
        $topUsers = DB::table('attemptedusers')
            ->join('users', 'attemptedusers.user_id', '=', 'users.id') // Join with users table
            ->select('attemptedusers.user_id', 'users.name as user_name', DB::raw('AVG(attemptedusers.percentage_scored) as avg_score')) // Select user name from users table
            ->groupBy('attemptedusers.user_id', 'users.name') // Group by user_id and user name
            ->orderBy('avg_score', 'desc')
            ->take(4)
            ->get();
             if ($user) {
            if (session('role') == 'teacher') {
                return view('dashboard', [
                    'user' => $user,
                    'quizCount' => $quizCount,
                    'studentCount' => $studentCount,
                    'recentQuizzes' => $recentQuizzes,
                    'topusers' => $topUsers
                ]);
            } elseif (session('role') == 'student') {
                return view('studentdashboard', ['user' => $user, 'quizCount' => $quizCount]);
            } else {
                return redirect('/logout')->with('error', 'Invalid role');
            }
        } else {
            return redirect('/logout')->with('error', 'User not found');
        }
    }
}
