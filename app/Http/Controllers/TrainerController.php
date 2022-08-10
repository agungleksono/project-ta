<?php

namespace App\Http\Controllers;

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
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
