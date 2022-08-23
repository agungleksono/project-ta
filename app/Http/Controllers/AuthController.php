<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|confirmed|min:8',
            'name' => 'required|string',
            'email' => 'required|email:dns',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        try {
            DB::transaction(function () use($request) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => 2
                ]);

                DB::table('customers')->insert([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'user_id' => $user->id,
                ]);
            });

            return ResponseFormatter::success(null, 'Register success');
        
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }

    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|confirmed|min:8',
            'name' => 'required|string',
            'email' => 'required|email:dns',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        try {
            DB::transaction(function () use($request) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => 1
                ]);

                DB::table('administrators')->insert([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'user_id' => $user->id,
                ]);
            });

            return ResponseFormatter::success(null, 'Register success.');
        
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, 'Register failed', 400);
        }
    }

    public function registerTrainer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|confirmed|min:8',
            'name' => 'required|string',
            'email' => 'required|email:dns',
            'phone' => 'required|string',
            'address' => 'required|string',
            'cv' => 'required|file',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        $trainer_cv = $request->file('cv')->store('public/uploads/trainer/cv');
        $path = asset('storage/' . $trainer_cv);

        try {
            DB::transaction(function () use($request, $trainer_cv) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => 3
                ]);

                DB::table('trainers')->insert([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'cv' => Str::remove('public/', $trainer_cv),
                    'user_id' => $user->id,
                ]);
            });

            return ResponseFormatter::success(null, 'Register success.');
        
        } catch (\Throwable $th) {
            Helper::deleteFileOnStorage($path);
            return ResponseFormatter::error(null, $th, 400);
        }
    }

    public function login(Request $request)
    {
        // Login validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }
        
        // Check email & password
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return ResponseFormatter::error(null, 'Email or Password incorrect', 400);
        }

        $token = Str::random(40); // Generate random token

        // Update user token in DB
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $user->update(['api_token' => $token]);

        // $cookie = Cookie::queue('cookie', $token, 3);
        
        // Get user data relation
        $userData = User::with(['administrator', 'customer', 'trainer'])->where('id', '=', $id)->get();
        $responseData = [
            'id' => $id,
            'username' => Auth::user()->username,
            'email' => Auth::user()->email,
            'user_role' => Auth::user()->status,
            'api_token' => $token,
            // 'cookie' => $cookie
        ];

        if (Auth::user()->status == 1) {
            $responseData += $userData[0]->administrator; 
            return ResponseFormatter::success($responseData, 'Login success');
        }
        elseif (Auth::user()->status == 2) {
            $responseData += $userData[0]->customer;                       
            return ResponseFormatter::success($responseData, 'Login success');
        } 
        elseif (Auth::user()->status == 3) {
            $responseData += $userData[0]->trainer;            
            return ResponseFormatter::success($responseData, 'Login success');
        }

    }

    public function logout() {
        $user = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['api_token' => null]);
        
        // Response when failed query to DB
        if ($user < 1) return ResponseFormatter::error(null, 'Logout failed', 400);

        return ResponseFormatter::success(null, 'Logout success');
    }

    public function loginTest(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function test(Request $request) {
        $x = Cookie::get('token');
        return now()->format('ymd');
        // return $_COOKIE["token"];
        // if (Cookie::has('token')) {
        //     return 'token';
        // } else {
        //     return 'no';
        // }
        // return Auth::user();
        // return request()->getHttpHost();
        // $userData = User::with(['customer', 'trainer'])->where('id', '=', 3)->get();
        // return response()->json($userData[0]->trainer);
    }
}
