<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        //
    }

    public function getAdminProfile() {
        $user = User::find(Auth::id());
        if (!$user) return ResponseFormatter::error(null, 'User not found', 400);

        $userData = User::with(['administrator'])
                            ->where('id', '=', Auth::id())
                            ->first();
        
        // if ($userData->isEmpty()) return ResponseFormatter::error(null, 'User not found', 400);

        return ResponseFormatter::success($userData, 'Success');
    }
}
