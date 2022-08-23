<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ResponseFormatter;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainerController extends Controller
{
    public function index()
    {
        try {
            $trainers = DB::table('users')
                        ->join('trainers', 'users.id', '=', 'trainers.user_id')
                        ->select('users.id', 'trainers.name', 'users.username', 'users.email', 'trainers.address', 'trainers.phone', 'trainers.photo', 'trainers.cv', 'trainers.id as trainer_id')
                        ->where('users.status', 3)
                        ->orderBy('users.created_at', 'desc')
                        ->get();
            // $trainers = User::with(['trainer'])->where('status', 3)->get();
            foreach($trainers as $trainer) {
                $trainer->cv = url('storage/' . $trainer->cv);
            }
            return ResponseFormatter::success($trainers, 'success');            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }

    public function show($id)
    {
        try {
            $trainer = User::with(['trainer'])
                        ->where('id', $id)
                        ->where('status', 3)
                        ->first();

            if (!$trainer) return ResponseFormatter::error(null, 'Data not found');
            $trainer->trainer_cv_path = url('storage/' . $trainer->trainer['cv']);
            return ResponseFormatter::success($trainer, 'success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'email' => 'required|image',
                'password' => 'required|string',
                'status' => 'required|numeric',
                'name' => 'required|date',
                'address' => 'required|date',
                'phone' => 'required|date',
                'photo' => 'required|date',
                'user_id' => 'required|numeric',
                'cv' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'error' => 'Invalid request',
                    'data' => $validator->errors()
                ], 400);
            }
    
            $trainer_cv = $request->file('trainer_cv')->store('trainer/cv', ['disk' => 'public']);
            $path = asset('uploads/' . $trainer_cv);

            DB::transaction(function () use ($request, $path) {
                User::create([
                    'username' => $request->post('username'),
                    'email' => $request->post('email'),
                    'password' => $request->post('password'),
                    'status' => 3,

                ]);

                Trainer::create([
                    'name' => $request->post('name'),
                    'address' => $request->post('address'),
                    'phone' => $request->post('phone'),
                    'cv' => $path,
                    'user_id' => $request->post('user_id'),        
                ]);
            });
    
    
            return ResponseFormatter::success(null, 'success');
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            // 'password' => 'required|confirmed|min:8',
            'name' => 'required|string',
            'email' => 'required|email:dns',
            'phone' => 'required|string',
            'address' => 'required|string',
            'photo' => 'required|image',
            'cv' => 'required|file',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        $trainer = Trainer::where('user_id', $id)->first();
        if (!$trainer) return ResponseFormatter::error(null, 'Data not found', 400);

        $cv = $request->file('cv')->store('trainer/cv', ['disk' => 'public']);
        $cvPath = asset('uploads/' . $cv);

        $photo = $request->file('photo')->store('avatar/trainer', ['disk' => 'public']);
        $photoPath = asset('uploads/' . $photo);
        try {

            DB::transaction(function () use ($request, $id, $cvPath, $photoPath) {
                DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'username' => $request->username,
                        'email' => $request->email,
                    ]);

                DB::table('trainers')
                    ->where('user_id', $id)
                    ->update([
                        'name' => $request->name,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'photo' => $photoPath,
                        'cv' => $cvPath,
                    ]);
            });
    
            // $trainer->username = $request->post('username', $trainer->username);
            // $trainer->password = $request->post('password', $trainer->password);
            // $trainer->name = $request->post('name', $trainer->name);
            // $trainer->email = $request->post('email', $trainer->email);
            // $trainer->phone = $request->post('phone', $trainer->phone);
            // $trainer->address = $request->post('address', $trainer->address);
            // $trainer->photo = $request->post('photo', $trainer->photo);
            // $trainer->cv = $request->post('cv', $trainer->cv);
            // $trainer->save();

            if ($trainer->photo || $trainer->cv) {
                Helper::deleteFileOnStorage([$trainer->photo, $trainer->cv]);
            }
            return ResponseFormatter::success(null, 'Success');            
        } catch (\Throwable $th) {
            Helper::deleteFileOnStorage([$cvPath, $photoPath]);
            return ResponseFormatter::error(null, $th, 400);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $trainer = Trainer::where('user_id', $id)->first();
            if (!$user) return ResponseFormatter::error(null, 'User not found', 400);
            
            DB::transaction(function () use ($id, $user, $trainer) {
                $user->delete();
                
                Helper::deleteFileOnStorage([$trainer->photo, $trainer->cv]);
                DB::table('trainers')->where('user_id', $id)->delete();
            });

            return ResponseFormatter::success(null, 'Data deleted');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }
}
