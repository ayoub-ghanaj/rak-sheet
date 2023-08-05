<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


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

    public function list_class(Request $request)
    {
        if (Auth::check()) {
            $year = $request->query('year');
            $class_val = $request->query('class');
            $semester = $request->query('semester');
            $staff_id = Auth::user()->getAuthIdentifier();
            return view('staff.class_show', [
                'user' => User::data($staff_id),
                'api' => User::data_api($staff_id),
                'data' => User::class_data($staff_id, $year , $semester , $class_val),
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
            'email' => 'required|email',
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


}
