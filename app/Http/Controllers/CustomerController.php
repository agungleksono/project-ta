<?php

namespace App\Http\Controllers;

use App\Helpers\FileFormatter;
use App\Helpers\Helper;
use App\Helpers\ResponseFormatter;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = User::with(['customer'])->where('status', 2)->get();
            return ResponseFormatter::success($customers, 'success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
        
    }
    
    public function show($id)
    {
        try {
            $customer = User::with(['customer'])
                        ->where('id', $id)
                        ->where('status', 2)
                        ->first();

            if (!$customer) return ResponseFormatter::error(null, 'Data not found');
            return ResponseFormatter::success($customer, 'success');
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
        //
    }


    public function edit($id)
    {
        //
    }

    public function getDataProfile() {
        $user = User::find(Auth::id());
        if (!$user) return ResponseFormatter::error(null, 'User not found', 400);

        $userData = User::with(['customer'])
                            ->where('id', '=', Auth::id())
                            ->get();
        
        if ($userData->isEmpty()) return ResponseFormatter::error(null, 'User not found', 400);

        $responseData = [
            'id' => Auth::id(),
            'username' => Auth::user()->username,
            'email' => Auth::user()->email,
            'api_token' => Auth::user()->api_token,
        ];
        $responseData += $userData[0]->customer;

        return ResponseFormatter::success($responseData, 'Success');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        $user = User::find(Auth::id());
        if (!$user) return ResponseFormatter::error(null, 'User not found', 400);

        try {
            DB::transaction(function () use ($request) {
                DB::table('users')
                    ->where('id', Auth::id())
                    ->update(['username' => $request->username]);
                
                DB::table('customers')
                    ->where('user_id', Auth::id())
                    ->update([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'address' => $request->address,
                    ]);
                
            });

            $userData = User::with(['customer'])
                            ->where('id', '=', Auth::id())
                            ->get();
            
            $responseData = [
                'id' => Auth::id(),
                'username' => $userData[0]->username,
                'email' => $userData[0]->email,
                'api_token' => Auth::user()->api_token,
            ];
            $responseData += $userData[0]->customer;
            
            return ResponseFormatter::success($responseData, 'Update profile success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, 'Update profile failed', 400);
        }
    }

    public function updateProfilePicture(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->get();
        if (!$customer) {
            return ResponseFormatter::error(null, 'Data not found', 400);
        } else {
            if ($customer[0]->photo) {
                Helper::deleteFileOnStorage($customer[0]->photo);
            }
        }

        // Save new image
        $photo = $request->file('photo')->store('avatar/customer', ['disk' => 'public']);
        // $path = FileFormatter::name($photo);
        $path = asset('uploads/' . $photo);
        // $path = asset('storage/' . $photo);
        DB::table('customers')
            ->where('user_id', Auth::id())
            ->update([
                'photo' => $path,
            ]);
        
        return ResponseFormatter::success($path, 'Image updated successfully');
    }

    public function destroy($id)
    {        
        try {
            $user = User::findOrFail($id);
    
            if (!$user) {
                return ResponseFormatter::error(null, 'User not found', 400);
            }

            DB::transaction(function() use($id, $user) {
                $user->delete();

                DB::table('customers')->where('user_id', $id)->delete();
            });

            return ResponseFormatter::success(null, 'Data deleted');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }
}
