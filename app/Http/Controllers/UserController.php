<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Low_Subjects;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function create()
    {
        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }
        return view('staff.register');
    }

    public function list_class_stats(Request $request)
    {
        if (Auth::check()) {
            $year = $request->query('year');
            $grade_val = $request->query('grade');
            $class_val = $request->query('class');
            // $semester = $request->query('semester');
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.class_show_stats', [
                'user' => User::data($staff_id),
                'api' => User::data_api($staff_id),
                'data' => User::class_stats_data($staff_id, $year  , $class_val , $grade_val),
            ]);
        }
        return view('staff.login');
    }
    public function dropdb(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $pass = $request->input('password');
            $staff_id = Auth::user()->getAuthIdentifier();

            if (Hash::check($pass, $user->password)) {
                User::clear($user->id);
            }

            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }
        return view('staff.login');
    }
    public function list_class(Request $request)
    {
        if (Auth::check()) {
            $year = $request->query('year');
            $grade_val = $request->query('grade');
            $class_val = $request->query('class');
            $semester = $request->query('semester');
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.class_show', [
                'user' => User::data($staff_id),
                'api' => User::data_api($staff_id),
                'data' => User::class_data($staff_id, $year , $semester , $class_val , $grade_val),
            ]);
        }
        return view('staff.login');
    }
    public function list()
    {
        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.list', [
                'user' => User::data($staff_id),
                'api' => User::data_api($staff_id),
                'list' => User::data_list($staff_id),
            ]);
        }
        return view('staff.login');
    }
    public function addshow()
    {
        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.add', [
                'user' => User::data($staff_id),
                'api' => User::data_api($staff_id),
            ]);
        }
        return view('staff.login');
    }
    public function lookup()
    {
        return view('staff.lookup', [
        ]);
    }

    public function index()
    {
        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }
        return view('staff.login');
    }

    public function login()
    {
        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }
        return view('staff.login');
    }

    public function handleLogin(Request $req)
    {
        if (Auth::attempt($req->only(['email', 'password']))
        ) {
            $staff_id = Auth::user()->getAuthIdentifier();
            // Generate a random token
            $token = Str::random(60);

            // Save the token in the user's token_api field
            Auth::user()->update([
                'token_api' => $token,
            ]);
            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }

        return redirect()
            ->route('staff.login')
            ->with('error', 'Invalid Credentials');
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()
        ->route('staff.login');
    }
    public function make()
    {
        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users', // Add 'unique:users' to the email validation rule
            'password' => 'required'
        ]);

        // Generate a random token
        $token = Str::random(60);
        // Create an array with request data and the generated token
        $requestData = array_merge(request(['name', 'email', 'password']), ['token_api' => $token]);

        $user = User::create($requestData );


        auth()->login($user);

        if (Auth::check()) {
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.dash', [
                'user' => User::data($staff_id),
                'sub' => User::data_sub($staff_id),
                'data' => User::stats($staff_id),
            ]);
        }
        return redirect()
        ->route('staff.register');
    }





    // subjects


    public function low_subs()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->rank === 'admin') {
                $staff_id = $user->getAuthIdentifier();
                $subjects = Low_Subjects::all();
                return view('staff.subjects', [
                    'user' => User::data($staff_id),
                    'lowSubjects' => $subjects,
                ]);
            } else {
                return view('staff.dash'); // Display a page indicating access denied for non-admin users
            }
        }

        return view('staff.login');
    }
    public function low_subs_ed_index($id)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->rank === 'admin') {
                $staff_id = $user->getAuthIdentifier();
                $subject = Low_Subjects::find($id);
                if (!$subject) {
                    return redirect()->route('low_subjects.index')->with('error', 'Subject not found.');
                }
                $lowSubject = Low_Subjects::findOrFail($id);
                return view('staff.subjects_edite', [
                    'user' => User::data($staff_id),
                    'lowSubject' => $lowSubject,
                ]);
            } else {
                return view('staff.dash'); // Display a page indicating access denied for non-admin users
            }
        }

        return view('staff.login');
    }
    public function low_subs_ad_index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->rank === 'admin') {
                $staff_id = $user->getAuthIdentifier();
                return view('staff.subjects_add', [
                    'user' => User::data($staff_id),
                ]);
            } else {
                return view('staff.dash'); // Display a page indicating access denied for non-admin users
            }
        }

        return view('staff.login');
    }
    public function low_subs_add(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->rank === 'admin') {
                $staff_id = $user->getAuthIdentifier();
                $data = $request->validate([
                    'name' => 'required|max:255',
                ]);

                Low_Subjects::create($data);
                return redirect()->route('low_subjects.index');
            } else {
                return view('staff.dash'); // Display a page indicating access denied for non-admin users
            }
        }

        return view('staff.login');
    }
    public function low_subs_update(Request $request, $id)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->rank === 'admin') {
                $data = $request->validate([
                    'name' => 'required|max:255',
                ]);

                $subject = Low_Subjects::findOrFail($id);
                $subject->update($data);
                return redirect()->route('low_subjects.index');
            } else {
                return view('staff.dash'); // Display a page indicating access denied for non-admin users
            }
        }

        return view('staff.login');
    }
    public function low_subs_destroy($id)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->rank === 'admin') {
                $subject = Low_Subjects::findOrFail($id);
                $subject->delete();
                return redirect()->route('low_subjects.index');
            } else {
                return view('staff.dash'); // Display a page indicating access denied for non-admin users
            }
        }

        return view('staff.login');
    }


}
