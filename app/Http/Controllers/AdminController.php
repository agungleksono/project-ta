<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function index()
    {
        //
    }

    public function getAdminProfile() 
    {
        $user = User::find(Auth::id());
        if (!$user) return ResponseFormatter::error(null, 'User not found', 400);

        $userData = User::with(['administrator'])
                            ->where('id', '=', Auth::id())
                            ->first();
        
        // if ($userData->isEmpty()) return ResponseFormatter::error(null, 'User not found', 400);

        return ResponseFormatter::success($userData, 'Success');
    }

    public function editAdminProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        try {
            DB::transaction(function() use($request) {
                DB::table('users')
                    ->where('id', Auth::id())
                    ->update(['username' => $request->username]);
            
                DB::table('administrators')
                ->where('user_id', Auth::id())
                ->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            });
            
            return ResponseFormatter::success(null, 'success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }
}
