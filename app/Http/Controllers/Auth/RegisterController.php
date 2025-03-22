<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register()
    {
        $role = DB::table('role_type_users')->get();
        return view('auth.register',compact('role'));
    }

    public function storeUser(Request $request)
    {
        try {
            $request->validate([
                'name'      => 'required|string|max:255',
                'email'     => 'required|string|email|max:255|unique:users',
                'role_name' => 'required|string|max:255',
                'password'  => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);
    
            $dt       = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();
    
            User::create([
                'name'      => $request->name,
                'avatar'    => $request->image,
                'email'     => $request->email,
                'join_date' => $todayDate,
                'role_name' => $request->role_name,
                'password'  => Hash::make($request->password),
            ]);
    
            return redirect()->route('login')->with('success', 'Create new account successfully :)');
        } catch (QueryException $e) {
            Log::error('Creating user: ' . $e->getMessage() );
            return back()->back()->with('error', 'Create new account failed :(');
        }
    }
}
